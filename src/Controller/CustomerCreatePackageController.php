<?php

namespace App\Controller;

use App\Form\ListOfficesForm;
use App\Entity\Offices;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CustomerCreatePackageController extends Root_DashboardController {

    public function create(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/dashboard', 'Create-Package'=>'/dashboard/create'];

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
        $address = ($this->CustomerAddressQuery($connection, $user['id']))[0];
        $costdata = [];

        $packageBundle = $this->createPackage($user['id']);
        $packageForm = $packageBundle[1];
        $packageForm->handleRequest($request);


        $office = new Offices();
        $officeList = $this->getOfficeQuery($connection, $packageBundle[0]->getrState());
        $listing = [];
        foreach ($officeList as $office) {
            array_push($listing, [$office['OfficeID'].' - '.$office['Street'].' '.$office['City'].', '.$office['StateAbbreviation'].' '.$office['ZIP'] => $office['OfficeID']]);
        }

        $officeForm = $this->createFormBuilder($office)
            ->add('OfficeID', ChoiceType::class, ['label'=> false, 'choices'=> $listing]) 
            ->getForm();

        if ($packageForm->isSubmitted() && $packageForm->isValid()) {
            // if use customer address, set address
            $packageBundle[0] = $packageForm->getData();

            if ($packageForm->getClickedButton() && $packageForm->getClickedButton()->getName() === 'submit'){

                $prices = ($this->CostQuery($connection, $packageBundle[0]->getService()))[0];
                $costs = $this->getTotal(
                    $packageBundle[0]->getWeight(), 
                    $prices['WeightLimit'], 
                    $prices['WeightPriceMultiplier'],
                    $prices['BasePrice']);

                $costdata = [
                    'weight' =>  $packageBundle[0]->getWeight(),
                    'service' => $prices['ServiceName'],
                    'BasePrice' => $prices['BasePrice'],
                    'WeightLimitCost' => $costs[1],
                    'total' => $costs[0]+$costs[1]
                ];

                $packageBundle[0]->setTotal($costdata['total']);
                
                $invoiceID = ($this->CustomerPackageSubmitQuery($connection, $packageBundle[0]))[0]['id'];
                    $this->get('session')->getFlashBag()->add('invoiceID', $invoiceID);
                    return $this->redirectToRoute("app-customer-invoice-id", ['id' => $invoiceID]);

            } else if($packageForm->getClickedButton() && $packageForm->getClickedButton()->getName() === 'next') {
            
                return $this->render('customer/create.html.twig', [
                    'logout'=>$logoutForm->createView(),
                    'email'=>$user['id'],
                    'name'=> $name["FName"]." ".$name["LName"],
                    'pickupForm' => $packageForm->createView(),
                    'breadcrumbs' => $breadcrumbs,
                    'total' => $costdata,
                    'officeList' => $officeForm->createView(),
                    'default_street' => $address['Street'],
                    'default_number' => $address['ApartmentNo'],
                    'default_city' => $address['City'],
                    'default_state'=> $address['StateName'],
                    'default_state_id'=> $address['StateID'],
                    'default_zip' => $address['ZIP']
                ]);
            } else if($packageForm->getClickedButton() && $packageForm->getClickedButton()->getName() === 'continue') {
                
                $packageBundle[0]->setLocation($packageForm['Location']->getData());
                
                $prices = ($this->CostQuery($connection, $packageBundle[0]->getService()))[0];
                $costs = $this->getTotal(
                    $packageBundle[0]->getWeight(), 
                    $prices['WeightLimit'], 
                    $prices['WeightPriceMultiplier'],
                    $prices['BasePrice']);  
                $costdata = [
                    'weight' =>  $packageBundle[0]->getWeight(),
                    'service' => $prices['ServiceName'],
                    'BasePrice' => $prices['BasePrice'],
                    'WeightLimitCost' => $costs[1],
                    'total' => $costs[0]+$costs[1]
                ];
                $packageBundle[0]->setTotal($costdata['total']);
                
                return $this->render('customer/create.html.twig', [
                    'logout'=>$logoutForm->createView(),
                    'email'=>$user['id'],
                    'name'=> $name["FName"]." ".$name["LName"],
                    'payment' => $packageForm->createView(),
                    'officeLocation' => $packageBundle[0]->getLocation(),
                    'breadcrumbs' => $breadcrumbs,
                    'total' => $costdata,
                    'default_street' => $address['Street'],
                    'default_number' => $address['ApartmentNo'],
                    'default_city' => $address['City'],
                    'default_state'=> $address['StateName'],
                    'default_state_id'=> $address['StateID'],
                    'default_zip' => $address['ZIP']
                    ]); 

            }
        }

        return $this->render('customer/create.html.twig', [
            'logout'=>$logoutForm->createView(),
            'email'=>$user['id'],
            'name'=> $name["FName"]." ".$name["LName"],
            'package' => $packageForm->createView(),
            'breadcrumbs' => $breadcrumbs,
            'total' => $costdata,
            'default_street' => $address['Street'],
            'default_number' => $address['ApartmentNo'],
            'default_city' => $address['City'],
            'default_state'=> $address['StateName'],
            'default_state_id'=> $address['StateID'],
            'default_zip' => $address['ZIP']
            ]);
    }

}