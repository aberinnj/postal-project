<?php

namespace App\Controller;

use App\Entity\Credentials;
use App\Entity\Registration;
use App\Entity\Tracking;
use App\Form\TrackingForm;
use App\Form\CustomerLoginForm;
use App\Form\EmployeeLoginForm;
use App\Form\CustomerRegistrationForm;
use App\Form\EmployeeRegistrationForm;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\DBAL\Driver\Connection;

class Root_HomeController extends AbstractController {

    //
    public function signIn_as_customer() {
        $credentials = new Credentials();
        $credentialsForm = $this->createForm(CustomerLoginForm::class, $credentials);

        return Array($credentials, $credentialsForm);
    }

    public function handleSignIn_as_customer(Connection $connection, Request $request, $form, $data) {
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pw = $this->CustomerUserQuery($connection, $data);
                if (!empty($pw) && $this->passmatch($data, $pw[0]['password'])) {

                    $session = $this->get('session');
                    $session->clear();
                    $session->set('user', ['id'=>$data->getEmail(),
                    'type'=>'customer']);

                    return $this->redirectToRoute('app-customer-home');
                } else if (count($pw) == 0) {
                    return "Invalid";
                } else if (!empty($pw) && !$this->passmatch($data, $pw[0]['password'])) {
                    return "Invalid";
                }
                return null;
        }
        return null;
    }

    //
    public function signIn_as_employee() {
        $employees_credentials = new Credentials();
        $employees_credentialsForm = $this->createForm(EmployeeLoginForm::class, $employees_credentials);
        return Array($employees_credentials, $employees_credentialsForm);
    }

    public function handleSignIn_as_employee(Connection $connection, Request $request, $credentialsForm, $credentials) {
        $credentialsForm->handleRequest($request);
        if($credentialsForm->isSubmitted() && $credentialsForm->isValid()) {
            $credentials = $credentialsForm->getData();

            $pw = $this->EmployeeUserQuery($connection, $credentials);

            if (!empty($pw) && $this->passmatch($credentials, $pw[0]['password'])) {

                $session = $this->get('session');
                $session->clear();
                $session->set('user', ['id'=>$credentials->getEmployeeID(),
                'type'=>'employee']);

                return $this->redirectToRoute('app-employee-home');
            } 
            elseif(!empty($pw) && !$this->passmatch($credentials, $pw[0]['password'])) {
                return FALSE;
            }
            else if(count($pw) == 0) {
                return FALSE;
            }
        }
        return null;
    }

    //
    public function tracking($new_tracking_found=null) {


        $tracking = new Tracking();
        $tracking->setPackageID($new_tracking_found);

        $trackingForm = $this->createForm(TrackingForm::class, $tracking);
        return Array($tracking, $trackingForm);
    }

    public function handleTracking(Request $request, $trackingForm, $tracking){
        
        $trackingForm->handleRequest($request);
        if ($trackingForm->isSubmitted() && $trackingForm->isValid()) {
            $tracking = $trackingForm->getData();

            return $this->redirectToRoute('app-track-id', ['id'=> $tracking->getPackageID()]);
        }
        return null;
    }

    //
    public function signUp_as_customer(){
        $registration = new Registration();
        $registrationForm = $this->createForm(CustomerRegistrationForm::class, $registration);
        return Array($registration, $registrationForm);
    }

    public function handleSignUp_as_customer(Connection $connection, Request $request, $registrationForm, $registration){
                    
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $registration = $registrationForm->getData();

            $this->registerCustomerQuery($connection, $registration);
            $this->get('session')->getFlashBag()->add('registration-type', 'Customer');
            $this->get('session')->getFlashBag()->add('registration-id', $registration->getEmail());
            return $this->redirectToRoute('app-registration-complete');
        }
        return null;

    }


    //
    protected function passmatch(Credentials $credentials, String $password) {
        if ($credentials->getPassword() == $password) {
            return TRUE;
        }
        return FALSE;
    }


    /*******************************************************************************
     * All Home Queries
    *******************************************************************************/
    protected function CustomerUserQuery(Connection $connection, Credentials $credentials) {
        try{
            $sql = "SELECT c.Password as password FROM customercredentials as c WHERE c.Email = :email";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $credentials->getEmail());
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }
    
        protected function registerCustomerQuery(Connection $connection, Registration $registration) {

        try{
            
            $customer_sql = "INSERT INTO customer (FName, MInit, LName, Email, State, City, ZIP, Street, ApartmentNo)
            VALUES (:FName, :MInit, :LName, :Email, :State, :City, :ZIP, :Street, :ApartmentNo)";

            $customer_credentials_sql = "INSERT INTO customercredentials (Email, Password)
            VALUES ((SELECT cust.Email FROM customer as cust where cust.Email=:Email), :Password)";

            $stmt = $connection->prepare($customer_sql);
            $stmt->bindValue(':FName', $registration->getFName());
            $stmt->bindValue(':MInit', $registration->getMInit());
            $stmt->bindValue(':LName', $registration->getLName());
            $stmt->bindValue(':Email', $registration->getEmail());
            $stmt->bindValue(':State', $registration->getState());
            $stmt->bindValue(':City', $registration->getCity());
            $stmt->bindValue(':ZIP', $registration->getZIP());
            $stmt->bindValue(':Street', $registration->getStreet());
            $stmt->bindValue(':ApartmentNo', $registration->getApartmentNo());
            $stmt->execute();

            $stmt = $connection->prepare($customer_credentials_sql);
            $stmt->bindValue(':Email', $registration->getEmail());
            $stmt->bindValue(':Password', $registration->getPassword());
            $stmt->execute();

            $stmt = null;
        } catch (PODException $e){ 

            echo "Error " . $e->getMessage();
        }
    }

    //
    protected function registerEmployeeQuery(Connection $connection, Registration $registration) {
        try{

            $sql = "INSERT INTO employee (FirstName, MiddleName, LastName, OfficeID) VALUES (:firstname, :middlename, :lastname, :office)";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':firstname', $registration->getFName());
            $stmt->bindValue(':middlename', $registration->getMInit());
            $stmt->bindValue(':lastname', $registration->getLName());
            $stmt->bindValue(':office', $registration->getOffice());
            $stmt->execute();

            $sql = "SELECT LAST_INSERT_ID() as id;";
            $stmt = $connection->prepare($sql);
            $stmt->execute();

            $id = ($stmt->fetchAll())[0];            

            $sql = "INSERT INTO employeecredentials (EmployeeID, Password) VALUES ((SELECT e.EmployeeID FROM employee as e WHERE e.EmployeeID = :id ), :password)";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id['id']);
            $stmt->bindValue(':password', $registration->getPassword());
            $stmt->execute();

            return $id['id'];

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function trackingQuery(Connection $connection, $tracking): array {

        try{
            $sql = "SELECT DISTINCT t.Update_Date as Date, t.TrackingNote as Note FROM tracking as t, package as p WHERE t.Package_ID = :pID ORDER BY t.Tracking_Index ASC";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':pID', $tracking);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function statusQuery(Connection $connection, $tracking) {
        try{
            $sql = "SELECT DISTINCT s.Status as Status FROM package as p, status as s WHERE p.PackageID = :pID AND p.Status = s.Code";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':pID', $tracking);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    // 
    protected function EmployeeUserQuery(Connection $connection, Credentials $credentials) {
        try{
            $sql = "SELECT e.Password as password FROM employeecredentials as e WHERE e.EmployeeID = :employeeID";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':employeeID', $credentials->getEmployeeID());
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    // 
    protected function getAllOfficeQuery(Connection $connection) {
        try{
            $sql = "SELECT o.OfficeID as office FROM office as o";

            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

}