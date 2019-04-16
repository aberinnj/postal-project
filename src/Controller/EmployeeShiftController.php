<?php

namespace App\Controller;

use App\Entity\Tracking;
use App\Entity\Package;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeeShiftController extends Root_DashboardController {
   
    public function start(Connection $connection, Request $request, $shift) {
        $session = $this->get('session');
        $user = $session->get('user');
        $name = ($this->EmployeesDetailsQuery($connection, $user['id']))[0];

        $shiftdata = $this->getShiftQuery($connection, $user['id']);
        if (count($shiftdata) == 0) {
            return $this->redirectToRoute('app-employee-delivery');
        }

        $action = $this->requestPage('employee', 'app-employee');
        if ($action) {
            return $action;
        }   

        $endShift = new Tracking();
        $endShiftForm = $this->createFormBuilder($endShift)
            ->add('endShift', SubmitType::class, [ 'label' => 'End Shift', 'attr'=>['class'=>'button is-primary is-fullWidth']] )
            ->getForm();
        $endShiftForm->handleRequest($request);
        if ($endShiftForm->isSubmitted() && $endShiftForm->getClickedButton() && $endShiftForm->getClickedButton()->getName() === 'endShift' ) {

            $this->endShift($connection, $shift);
            return $this->redirectToRoute('app-employee-home');
        }

        $shiftDetails = ($this->getShiftDetailsQuery($connection, $shift))[0];
        $packages = $this->getPackagesForVehicle($connection, $shiftDetails['VehicleID']);


        $offices = ($this->getShippingOfficesQuery($connection, $name['OfficeID']));
        $listing = [];
        foreach ($offices as $office) {

            if($office['isRegional'] == 1 && $office['OfficeID'] !== $name['OfficeID'])
            {
                array_push($listing, [$office['OfficeID'].' - [REGIONAL] - '.$office['Street'].' '.$office['City'].', '.$office['StateAbbreviation'].' '.$office['ZIP'] => $office['OfficeID']]);
            } else if($office['OfficeID'] !== $name['OfficeID']) {
                array_push($listing, [$office['OfficeID'].' - '.$office['Street'].' '.$office['City'].', '.$office['StateAbbreviation'].' '.$office['ZIP'] => $office['OfficeID']]);
            }
        }
        array_push($listing, ['[Deliver to Destination]'=>'HOME01']);














        $Deliver = new Package();
        $deliveryFault = "";
        $DeliverForm = $this->createFormBuilder($Deliver)
            ->add('PackageID', TextType::class, [ 'label' => false, 'required'=>true ])
            ->add('Location', ChoiceType::class, [ 'label' => '* Office List ', 'choices' => $listing, 'required'=>true ])
            ->add('State', TextType::class, ['label'=> false, 'required'=>true])
            ->add('Ship', SubmitType::class, [ 'label' => 'Deliver'] )
            ->getForm();
        $DeliverForm->handleRequest($request);
        if($DeliverForm->isSubmitted() && $DeliverForm->isValid()){
            $Deliver = $DeliverForm->getData();
            
            if ($Deliver->getLocation() === "HOME01")
            {
                $destination = ($this->isHomeDeliveryPossibleQuery($connection, $name['OfficeID'], $Deliver->getState()));
                if(count($destination) === 0) {
                    // destination is in another state
                    $deliveryFault = $name['OfficeID'];

                }
                else {
                    // destination might be nearby/in this state
                    $deliveryFault = "";
                    $this->completeDeliverQuery($connection, $Deliver);

                    return $this->redirect($request->getUri());
                }
                
            } else {

                // update package
                $this->deliverQuery($connection, $Deliver);
                return $this->redirect($request->getUri());
                
            }


            
        }










        return $this->render(
            'employee/shift.html.twig', [
            'firstname'=>$name['FirstName'],
            'id'=>$user['id'],
            'name'=>$name['FirstName'].' '.$name['LastName'],
            'vehicle' => $shiftDetails['VehicleID'],
            'packages' => $packages,
            'fault' => $deliveryFault,
            'checkin' => $shiftDetails['checkin'],
            'deliver' => $DeliverForm->createView(),
            'endShift' => $endShiftForm->createView()
            ]
        );
    }
}