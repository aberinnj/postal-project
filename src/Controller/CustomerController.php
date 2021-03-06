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
        $breadcrumbs = ['Home'=>'/dashboard'];

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }

        $bestFiveOrders = $this->CustomerDashOrdersQuery($connection, $user['id']); 
        $message = [];
        $name = ($this->CustomerDetailsQuery($connection, $user['id']))[0];
        return $this->render('customer/dashboard.html.twig', [
            'logout'=> $logoutForm->createView(),
            'breadcrumbs'=> $breadcrumbs,
            'name'=> $name["FName"]." ".$name["LName"],
            'firstname'=> $name["FName"],
            'orders' => $bestFiveOrders,
            'messages' => $message
        ]);
    }

    /**
     * @Route("/dashboard/orders", name="app-customer-orders")
    */
    public function customer_orders(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/dashboard', 'Orders'=>'/dashboard/orders'];

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
            'breadcrumbs'=> $breadcrumbs,
            'name'=> $name["FName"]." ".$name["LName"],
            'orderList' => $orderList
            ]);
    }
 
}