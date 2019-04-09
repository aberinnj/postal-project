<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

use Doctrine\DBAL\Driver\Connection;

class EmployeeController extends Root_DashboardController {

    public function home(Connection $connection, Request $request) {

        $action = $this->requestPage('employee', 'app-employee');

        if ($action) {
            return $action;
        }
        return $this->employee_dashboard($connection, $request);

    }
    
    public function employee_dashboard(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }
        return $this->render('employee/dashboard.html.twig', ['id'=>$user['id'], 'type'=>$user['type'], 'logout'=>$logoutForm->createView()]);
    }
}