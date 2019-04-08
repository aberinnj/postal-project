<?php

namespace App\Controller;

use App\Entity\Credentials;
use App\Entity\Registration;
use App\Form\CustomerLoginForm;
use App\Form\EmployeeRegistrationForm;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\DBAL\Driver\Connection;

class RootController extends AbstractController {

   //
   public function customer(Connection $connection, Request $request) {
    $credentials = new Credentials();
    $credentialsForm = $this->createForm(CustomerLoginForm::class, $credentials);

    $credentialsForm->handleRequest($request);
    if($credentialsForm->isSubmitted() && $credentialsForm->isValid()) {
        $credentials = $credentialsForm->getData();
    }

    return $credentialsForm;
}

//
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

    /*******************************************************************************
    *******************************************************************************/
    protected function registerQuery(Connection $connection, Registration $registration) {

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
protected function passmatch(Credentials $credentials, String $password) {
    if ($credentials->getPassword() == $password) {
        return TRUE;
    }
    return FALSE;
}

//
protected function registerUserQuery(Connection $connection, Registration $registration) {
    try{

        $sql = "INSERT INTO employee (FirstName, MiddleName, LastName, OfficeID) VALUES (:firstname, :middlename, :lastname, :office)";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':firstname', $registration->getFName());
        $stmt->bindValue(':middlename', $registration->getMInit());
        $stmt->bindValue(':lastname', $registration->getLName());
        $stmt->bindValue(':office', 'HOU002');
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


}