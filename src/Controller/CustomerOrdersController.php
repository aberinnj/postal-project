<?php

namespace App\Controller;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CustomerOrdersController extends Root_DashboardController {

    public function list(Connection $connection, Request $request) {
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