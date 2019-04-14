<?php

namespace App\Controller;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CustomerInvoiceController extends Root_DashboardController {

    public function list(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/dashboard', 'Orders'=>'/dashboard/orders', 'Invoice' =>'/dashboard/orders/invoice'];

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
        $trackingHandler = $this->handleTracking($request, $trackingForm, $trackingBundle[0], "Invoice");

        if($trackingHandler) {
            return $trackingHandler;
        }

        $name = ($this->CustomerDetailsQuery($connection, $user['id']))[0];
        return $this->render('customer/invoice.html.twig', [
            'logout' => $logoutForm->createView(),
            'breadcrumbs'=> $breadcrumbs,
            'tracking' => $trackingForm->createView(),
            'name'=> $name["FName"]." ".$name["LName"],
        ]);
    }

    
    public function viewWithID(Connection $connection, Request $request, $id) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/dashboard', 'Orders'=>'/dashboard/orders', 'Invoices' =>'/dashboard/orders/invoice', $id=>'/dashboard/orders/invoice/'.$id];

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
        return $this->render('customer/invoice_id.html.twig', [
            'logout' => $logoutForm->createView(),
            'id' => $id,
            'breadcrumbs'=> $breadcrumbs,
            'name'=> $name["FName"]." ".$name["LName"],
        ]);
    }
}