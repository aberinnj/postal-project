<?php

namespace App\Controller;
use App\Entity\Delivery;
use App\Entity\Tracking;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\DBAL\Driver\Connection;

class EmployeeVehiclesController extends Root_DashboardController {
   
    public function home(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/employee/dashboard', 'Office'=>'/employee/dashboard/office', 'Vehicles'=>'/employee/dashboard/office/vehicles'];

        $name = ($this->EmployeesDetailsQuery($connection, $user['id']))[0];
        $packages = ($this->GetOfficePackages($connection, $name['OfficeID']));

        $action = $this->requestPage('employee', 'app-employee');
        if ($action) {
            return $action;
        }

        $logout = new Tracking();
        $logoutForm = $this->createFormBuilder($logout)
            ->add('logout', SubmitType::class, [ 'label' => 'Logout', 'attr'=>['class'=>'button is-dark is-fullWidth']] )
            ->getForm();
        $logoutForm->handleRequest($request);
        if ($logoutForm->isSubmitted() && $logoutForm->getClickedButton() && $logoutForm->getClickedButton()->getName() === 'logout' ) {
                $session = $this->get('session');
                $session->clear();
                return $this->redirectToRoute('app-main-page');
        }

        $vehicles = [];
        $data = ($this->GetAllVehiclesQuery($connection, $name['OfficeID']));
        
        if(count($data) > 0) {
            $vehicles = $data;
        }

 
        return $this->render( 'employee/vehicles.html.twig',[
            'firstname'=>$name['FirstName'],
            'id' => $user['id'],
            'name'=>$name['FirstName'].' '.$name['LastName'],
            'breadcrumbs' => $breadcrumbs,
            'logout'=>$logoutForm->createView(),
            'packages'=>$packages,
            'vehicles'=>$vehicles,
            'branch'=>$name['OfficeID']
        ]);
    }
}