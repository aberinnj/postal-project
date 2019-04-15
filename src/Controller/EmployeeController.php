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
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/employee/dashboard'];

        $action = $this->requestPage('employee', 'app-employee');
        if ($action) {
            return $action;
        }

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }

        $name = ($this->EmployeesDetailsQuery($connection, $user['id']))[0];
        return $this->render(
            'employee/dashboard.html.twig', [
            'firstname'=>$name['FirstName'],
            'name'=>$name['FirstName'].' '.$name['LastName'],
            'id'=>$user['id'],
            'breadcrumbs' => $breadcrumbs,
            'branch' => $name['OfficeID'],
            'logout'=>$logoutForm->createView()]
        );
    }
}