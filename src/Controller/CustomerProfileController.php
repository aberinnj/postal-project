<?php

namespace App\Controller;

use App\Form\ProfileForm;
use App\Entity\Registration;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CustomerProfileController extends Root_DashboardController {

    public function home(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        $breadcrumbs = ['Home'=>'/dashboard', 'Profile'=>'/dashboard/profile'];

        $action = $this->requestPage('customer', 'app-main-page');
        if ($action) {
            return $action;
        }

        $logoutForm = $this->logout();
        $logoutHandler = $this->do_logout($request, $logoutForm);

        if($logoutHandler) {
            return $logoutHandler;
        }
        $profileData = $this->GetProfileQuery($connection, $user['id'])[0];
        $profile = new Registration();
        $profile->setEmail($profileData['Email']);
        $profile->setFName($profileData['FName']);
        $profile->setMInit($profileData['MInit']);
        $profile->setLname($profileData['LName']);
        $profile->setState($profileData['State']);
        $profile->setCity($profileData['City']);
        $profile->setApartmentNo($profileData['ApartmentNo']);
        $profile->setStreet($profileData['Street']);
        $profile->setZIP($profileData['ZIP']);


        $profileForm = $this->createForm(ProfileForm::class, $profile);
        $profileForm->handleRequest($request);
        
        if($profileForm->isSubmitted() && $profileForm->isValid()) {
            $profile = $profileForm->getData();
            $this->UpdateProfileQuery($connection, $profile);
        }

        $name = ($this->CustomerDetailsQuery($connection, $user['id']))[0];

        $orderList = ($this->CustomerOrdersQuery($connection, $user['id']));
        return $this->render('customer/profile.html.twig', [
            'logout'=>$logoutForm->createView(),
            'breadcrumbs'=> $breadcrumbs,
            'name'=> $name["FName"]." ".$name["LName"],
            'profile' => $profileForm->createView()
        ]);

        
    }
}