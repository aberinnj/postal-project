<?php

namespace App\Controller;

use App\Entity\Tracking;
use App\Entity\Package;
use App\Form\PackageForm;
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
    protected function createPackage() {
        $package = new Package();
        $packageForm = $this->createForm(PackageForm::class, $package);
        return Array($package, $packageForm);
    }

    protected function do_createPackage(Request $request, $packageForm, $package) {
                
        $packageForm->handleRequest($request);
        if ($packageForm->isSubmitted() && $packageForm->isValid()) {
            $tracking = $packageForm->getData();

            $this->get('session')->getFlashBag()->add('', $package);
            return $this->redirectToRoute('app-track');
        }
        return null;
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
            $sql = "SELECT p.PackageID as id, t.last_update as date, t.TrackingNote as note, p.Status as status FROM package as p, (SELECT Tracking_Index, updated_id, last_update, TrackingNote FROM tracking RIGHT JOIN (SELECT tracking.Package_ID as updated_id, max(tracking.Update_Date) as last_update FROM tracking group by tracking.Package_ID) as updated ON tracking.Package_ID = updated.updated_id AND tracking.Update_Date = updated.last_update) as t WHERE p.PackageID = t.updated_id LIMIT 5 ";

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

}