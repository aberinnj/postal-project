<?php

namespace App\Controller;

use App\Entity\Tracking;
use App\Entity\Package;
use App\Form\CustomerPackageForm;
use App\Form\TrackingForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\DBAL\Driver\Connection;

class Root_DashboardController extends AbstractController {

    //
    public function requestPage($expectedUserType, $defaultRoute) {
        
        $session = $this->get('session');
        if ($session->has('user') && $session->get('user')['type'] == $expectedUserType)  
        {
            return null;
            
        } 
        elseif ($session->has('user') && $session->get('user')['type'] != $expectedUserType){
            $session->clear();
            return $this->redirectToRoute($defaultRoute);
        }
        else {
            // not authenticated
            return $this->redirectToRoute($defaultRoute);
        }
    }

    //
    public function logout() {

        $tracking = new Tracking();
        $trackingForm = $this->createFormBuilder($tracking)
            ->add('Submit', SubmitType::class, [ 'label' => 'Logout', 'attr'=>['class'=>'button is-dark is-fullWidth']] )
            ->getForm();
        return $trackingForm;
    }

    //
    protected function do_logout(Request $request, $form) {
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $session = $this->get('session');
            $session->clear();
            return $this->redirectToRoute('app-main-page');
        }
        return null;
    }

    //
    public function tracking($new_tracking_found=null) {

        if ($new_tracking_found) {
            $tracking = $new_tracking_found;
        } else {
            $tracking = new Tracking();
        }

        $trackingForm = $this->createForm(TrackingForm::class, $tracking);
        return Array($tracking, $trackingForm);
    }

    public function handleTracking(Request $request, $trackingForm, $tracking, $type){
        
        $trackingForm->handleRequest($request);
        if ($trackingForm->isSubmitted() && $trackingForm->isValid()) {
            $tracking = $trackingForm->getData();


            $route = "";
            switch ($type) {
                case "Tracking":
                    $this->get('session')->getFlashBag()->add('trackID', $tracking);
                    $route = "app-customer-tracking-id";
                    break;
                case "Invoice":
                    $this->get('session')->getFlashBag()->add('invoiceID', $tracking);
                    $route = "app-customer-invoice-id";
                    break;
            }
            return $this->redirectToRoute($route, ['id'=>$tracking->getPackageID()]);
        }
        return null;
    }

    //
    protected function createPackage($data = null) {
        $package = new Package();
        if ($data) {
            $package->setEmail($data);
        }
        $packageForm = $this->createForm(CustomerPackageForm::class, $package);
        return Array($package, $packageForm);
    }

    
    protected function getTotal($weight, $limit, $multiplier, $baseprice) {
        $overLimitPenalty = 0;

        if($weight > $limit) {
            $overLimitPenalty = ($weight-$limit) * $multiplier;
        }
        return Array($baseprice, $overLimitPenalty);
    }

    /*******************************************************************************
     * All Dashboard Queries
    *******************************************************************************/
    protected function CustomerDetailsQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT FName, LName FROM customer WHERE customer.Email = :email;";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }
    
    protected function CustomerDashOrdersQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT p.PackageID as id, t.last_update as date, t.TrackingNote as note, s.Status as status FROM package as p, status as s, (SELECT Tracking_Index, updated_id, last_update, TrackingNote FROM tracking RIGHT JOIN (SELECT tracking.Package_ID as updated_id, max(tracking.Update_Date) as last_update FROM tracking group by tracking.Package_ID) as updated ON tracking.Package_ID = updated.updated_id AND tracking.Update_Date = updated.last_update) as t WHERE p.PackageID = t.updated_id AND p.Status = s.Code LIMIT 5 ";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function CustomerOrdersQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT p.PackageID as ID, s.Status as Status, p.send_date as Date, t.TransactionID as InvoiceID FROM  package as p, transaction as t, status as s WHERE p.Email = :email AND p.Status = s.Code AND p.PackageID = t.PackageID";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function CustomerAddressQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT c.Street, c.ApartmentNo, c.City, s.StateName, s.StateID as StateID, c.ZIP FROM customer as c, state as s WHERE c.Email = :email AND s.StateID = c.State";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function CostQuery(Connection $connection, $serviceID){
        try{
            $sql = "SELECT * FROM service as s WHERE s.ServiceID = :service";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':service', $serviceID);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function OfficesQuery(Connection $connection, $officeState) {
        try{
            $sql = "SELECT * FROM office as o, state as s WHERE s.StateName = :state AND s.StateID = o.State";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':state', $officeState);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function CustomerPackageSubmitQuery(Connection $connection, $package) {
     
        try{
            $sql = "INSERT INTO package (RecipientName, Email, Weight, Length, Width, Height, 
            dest_State, dest_City, dest_ZIP, dest_Street, dest_ApartmentNo,
            return_State, return_City, return_ZIP, return_Street, return_ApartmentNo,
            isFragile, send_date, Service, Status) VALUES (
                :Recipient,
                :Email,
                :Weight,
                :Length,
                :Width,
                :Height,
                :State,
                :City,
                :ZIP,
                :Street,
                :ApartmentNo,
                :rState,
                :rCity,
                :ZIP,
                :rStreet,
                :rApartmentNo,
                :isFragile,
                :sendDate,
                :service,
                :status
            )";

            $transaction = "INSERT INTO transaction (PackageID, TransactionTotal) VALUES ((SELECT LAST_INSERT_ID()), :total)";
            $getidsql = "SELECT LAST_INSERT_ID() as id";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':Recipient', $package->getRecipient());
            $stmt->bindValue(':Email', $package->getEmail());
            $stmt->bindValue(':Weight', $package->getWeight());
            $stmt->bindValue(':Length', $package->getLength());
            $stmt->bindValue(':Width', $package->getWidth());
            $stmt->bindValue(':Height', $package->getHeight());

            $stmt->bindValue(':State', $package->getState());
            $stmt->bindValue(':City', $package->getCity());
            $stmt->bindValue(':ZIP', $package->getZIP());
            $stmt->bindValue(':Street', $package->getStreet());
            $stmt->bindValue(':ApartmentNo', $package->getApartmentNo());

            $stmt->bindValue(':rState', $package->getrState());
            $stmt->bindValue(':rCity', $package->getrCity());
            $stmt->bindValue(':rZIP', $package->getrZIP());
            $stmt->bindValue(':rStreet', $package->getrStreet());
            $stmt->bindValue(':rApartmentNo', $package->getrApartmentNo());

            $stmt->bindValue(':isFragile', (int)$package->getIsFragile());
            $stmt->bindValue(':sendDate', date_format($package->getSendDate(), 'Y-m-d'));
            $stmt->bindValue(':service', $package->getService());
            $stmt->bindValue(':status', $package->getStatus());
            $stmt->execute();

            $stmt = $connection->prepare($transaction);
            $stmt->bindValue(':total', $package->getTotal());
            $stmt->execute();

            $stmt = $connection->prepare($getidsql);
            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }

    }
}