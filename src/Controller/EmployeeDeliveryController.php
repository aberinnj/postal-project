<?php

namespace App\Controller;

use App\Entity\Tracking;
use App\Entity\Delivery;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeDeliveryController extends Root_DashboardController {
   
    public function start(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/employee/dashboard', 'Make-Delivery'=>'/employee/dashboard/delivery'];
        $name = ($this->EmployeesDetailsQuery($connection, $user['id']))[0];       

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

        
        $vehicles = ($this->GetVehiclesQuery($connection, $name['OfficeID']));
        $listing = [];
        $counter = 0;
        foreach ($vehicles as $vehicle) {
            $counter += 1;
            array_push($listing, [$vehicle['OfficeID'].' Vehicle '.$counter.' - VIN('.$vehicle['VIN'].")"  =>$vehicle['VIN']]);
        }
 
        $packageVehicle = new Delivery();
        $packageVehicleForm = $this->createFormBuilder($packageVehicle)
            ->add('Vehicle', ChoiceType::class, [ 'label' => '* Vehicles List ', 'choices' => $listing, 'required'=>true ])
            ->add('Select', SubmitType::class, [ 'label' => 'Select Vehicle'] )
            ->getForm();

        $selected = "";
        $packages = [];
        $packageVehicleForm->handleRequest($request);
        if($packageVehicleForm->isSubmitted() && $packageVehicleForm->isValid()) {
            $packageVehicle = $packageVehicleForm->getData();
            $selected = $packageVehicle->getVehicle();

            $packages = $this->getPackagesForVehicle($connection, $selected);
        }

        $startShift = new Tracking();
        $startShiftForm = $this->createFormBuilder($startShift)
            ->add('startShift', SubmitType::class, [ 'label' => 'Start Shift', 'attr'=>['class'=>'button is-primary is-fullWidth']] )
            ->getForm();
        $startShiftForm->handleRequest($request);
        if ($startShiftForm->isSubmitted() && $startShiftForm->getClickedButton() && $startShiftForm->getClickedButton()->getName() === 'startShift' ) {

            $this->startShift($connection, $user['id'], $selected);
                    
            $shiftdata = $this->getShiftQuery($connection, $user['id']);
            if (count($shiftdata) > 0) {
                return $this->redirectToRoute('app-employee-shift', ['shift'=>$shiftdata[0]['session']]);
            }
        }

        
        $shiftdata = $this->getShiftQuery($connection, $user['id']);
        if (count($shiftdata) > 0) {
            return $this->redirectToRoute('app-employee-shift', ['shift'=>$shiftdata[0]['session']]);
        }

        return $this->render(
            'employee/delivery.html.twig', [
            'firstname'=>$name['FirstName'],
            'id'=>$user['id'],
            'name'=>$name['FirstName'].' '.$name['LastName'],
            'breadcrumbs' => $breadcrumbs,
            'vehicles' => $packageVehicleForm->createView(),
            'selected' => $selected,
            'packages' => $packages,
            'startShift' => $startShiftForm->createView(),
            'logout'=>$logoutForm->createView()]
        );
    }
}