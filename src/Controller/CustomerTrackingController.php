<?php

namespace App\Controller;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
        $breadcrumbs = ['Home'=>'/dashboard', 'Orders'=>'/dashboard/orders', 'Tracking' =>'/dashboard/orders/track', $id=>'/dashboard/orders/track/'.$id];

        $action = $this->requestPage('customer', 'app-main-page');
        if ($action) {
            return $action;
        }

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }

        $name = ($this->CustomerDetailsQuery($connection, $user['id']))[0];
        return $this->render('customer/track_id.html.twig', [
            'logout' => $logoutForm->createView(),
            'id' => $id,
            'breadcrumbs'=> $breadcrumbs,
            'name'=> $name["FName"]." ".$name["LName"],
        ]);
    }
}