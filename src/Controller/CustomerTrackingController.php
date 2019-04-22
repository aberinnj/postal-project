<?php

namespace App\Controller;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Tracking;

class CustomerTrackingController extends Root_DashboardController {

    public function list(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/dashboard', 'Orders'=>'/dashboard/orders', 'Tracking' =>'/dashboard/orders/track'];

        $action = $this->requestPage('customer', 'app-main-page');
        if ($action) {
            return $action;
        }

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }

        $trackingBundle = $this->tracking();
        $trackingForm = $trackingBundle[1];
        $trackingHandler = $this->handleTracking($request, $trackingForm, $trackingBundle[0], "Tracking");

        if($trackingHandler) {
            return $trackingHandler;
        }

        $name = ($this->CustomerDetailsQuery($connection, $user['id']))[0];
        return $this->render('customer/track.html.twig', [
            'logout' => $logoutForm->createView(),
            'breadcrumbs'=> $breadcrumbs,
            'tracking' => $trackingForm->createView(),
            'name'=> $name["FName"]." ".$name["LName"],
        ]);
    }

    public function viewWithID(Connection $connection, Request $request, $id) {
        $session = $this->get('session');
        $user = $session->get('user');
        $bag = $session->getFlashBag();
        $breadcrumbs = ['Home'=>'/dashboard', 'Orders'=>'/dashboard/orders', 'Tracking' =>'/dashboard/orders/track', $id=>'/dashboard/orders/track/'.$id];
//------------------
        $data = [];
        $status = [];
        $previous_tracking_data = null;
        
        //$bag = $session->getFlashBag();
        
        if ($bag->has('trackID')) {

            $previous_tracking_data = ($bag->get('trackID'))[0];
            
            $data = $this->trackingQuery($connection, $previous_tracking_data);
            $status = $this->statusQuery($connection, $previous_tracking_data);
        } 
        $action = $this->requestPage('customer', 'app-main-page');
        if ($action) {
            return $action;
        }

        $tr = new Tracking();
        $tr->setPackageID($id);
        $PID = $tr->getPackageID();
        $data = $this->trackingQuery($connection, $tr);
        $status = $this->statusQuery($connection, $tr);
        //$returnTransaction = ($this->getReturnAddressQuery($connection, $id))[0];


        $trackingBundle = $this->tracking($previous_tracking_data);
        $trackingForm = $trackingBundle[1];
        $trackingHandler = $this->handleTracking($request, $trackingForm, $trackingBundle[0], "Tracking");  

//---------------
        $action = $this->requestPage('customer', 'app-main-page');
        if ($action) {
            return $action;
        }

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }
        else if($trackingHandler) {
            return $trackingHandler;
        }

        $name = ($this->CustomerDetailsQuery($connection, $user['id']))[0];
        return $this->render('customer/track_id.html.twig', [
            'tracking' => $trackingForm->createView(),
            'data' => $data,
            'logout' => $logoutForm->createView(),
            'id' => $id,
            'status' =>$status,
            'breadcrumbs'=> $breadcrumbs,
            'name'=> $name["FName"]." ".$name["LName"],
        ]);
    }
}