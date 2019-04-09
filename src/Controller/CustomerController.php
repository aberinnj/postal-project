<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Doctrine\DBAL\Driver\Connection;

class CustomerController extends Root_DashboardController {

    public function home(Connection $connection, Request $request)
    {

        $action = $this->requestPage('customer', 'app-main-page');
        if ($action) {
            return $action;
        }

        return $this->customer_dashboard($connection, $request);

    }

    public function customer_dashboard(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }

        $name = ($this->CustomerDetailsQuery($connection, $user['id']))[0];
        return $this->render('customer/dashboard.html.twig', [
            'logout'=> $logoutForm->createView(),
            'name'=> $name["FName"]." ".$name["LName"]
        ]);
    } 


    /**
     * @Route("/dashboard/orders", name="app-customer-orders")
    */
    public function customer_orders(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');

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
        $orderList = ($this->CustomerOrdersQuery($connection, $user['id']));
        return $this->render('customer/orders.html.twig', [
            'logout'=>$logoutForm->createView(),
            'name'=> $name["FName"]." ".$name["LName"],
            'orderList' => $orderList
            ]);
    }


    /**
     * @Route("/dashboard/create", name="app-create-package")
    */
    public function customer_createPackage(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');

        $action = $this->requestPage('customer', 'app-main-page');
        if ($action) {
            return $action;
        }

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        $packageBundle = $this->createPackage();
        $packageForm = $packageBundle[1];
        $packageHandler = $this->do_createPackage($request, $packageForm, $packageBundle[0]);

        if($logoutHandler) {
            return $logoutHandler;
        }
        else if ($packageHandler) {
            return $packageHandler;
        }

        $name = ($this->CustomerDetailsQuery($connection, $user['id']))[0];
        return $this->render('customer/create.html.twig', [
            'logout'=>$logoutForm->createView(),
            'name'=> $name["FName"]." ".$name["LName"],
            'package' => $packageForm->createView()
            ]);
    }



    
    /**
     * @Route("/dashboard/profile", name="app-customer-profile")
    */
    public function customer_profile(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');

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
        return $this->render('customer/profile.html.twig', [
            'logout'=>$logoutForm->createView(),
            'name'=> $name["FName"]." ".$name["LName"]
        ]);
    }
}