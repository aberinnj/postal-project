<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

use Doctrine\DBAL\Driver\Connection;

class EmployeeReportsController extends Root_DashboardController {
   
    public function show(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/employee/dashboard', 'Reports'=>'/employee/dashboard/reports'];

        $action = $this->requestPage('employee', 'app-employee');
        if ($action) {
            return $action;
        }

        $ReportEmployeeDelivery = $this->ReportEmployeeDeliveryQuery($connection);
        $ReportEmployeeStats = $this->ReportEmployeeStats($connection);
        $ReportOfficeStats = $this->ReportOfficeStats($connection);
        $ReportLast30Days = $this->ReportLast30Days($connection);

        //$ReportRegionalStats = $this->ReportRegionalOfficeStatistics($connection);
        //            'reportRegionalStats' => $ReportRegionalStats,

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }

        $name = ($this->EmployeesDetailsQuery($connection, $user['id']))[0];
        return $this->render(
            'employee/reports.html.twig', [
            'firstname'=>$name['FirstName'],
            'id' => $user['id'],
            'name'=>$name['FirstName'].' '.$name['LastName'],
            'breadcrumbs' => $breadcrumbs,
            'reportEmployeeDelivery' => $ReportEmployeeDelivery,
            'reportEmployeeStats' => $ReportEmployeeStats,
            'reportOfficeStats' => $ReportOfficeStats,
            'reportLast30Days' => $ReportLast30Days,
            'logout'=>$logoutForm->createView()]
        );
    }
}