<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Entity\Tracking;
use App\Entity\Package;
use App\Form\PackageForm;
use App\Entity\Credentials;
use App\Form\CustomerLoginForm;
use App\Form\CustomerRegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Doctrine\DBAL\Driver\Connection;

class HomeController extends Root_HomeController {

    /**
     * @Route("/", name="app-main-page")
     */
    public function show_mainPage(Connection $connection, Request $request)
    {
        $loginBundle = $this->signIn_as_customer();
        $loginForm = $loginBundle[1];
        $loginHandler = $this->handleSignIn_as_customer($connection, $request, $loginForm, $loginBundle[0]);

        $trackingBundle = $this->tracking();
        $trackingForm = $trackingBundle[1];
        $trackingHandler = $this->handleTracking($request, $trackingForm, $trackingBundle[0]);

        $feedback = "";
        if($trackingHandler) {
            return $trackingHandler;
        }
        elseif($loginHandler && $loginHandler !== "Invalid") {
            return $loginHandler;
        }
        else if($loginHandler === "Invalid") {
            $feedback = "Login Unsuccessful";
        }

        return $this->render('home/home.html.twig', [
            'tracking' => $trackingForm->createView(), 
            'login' => $loginForm->createView(),
            'feedback'=> $feedback
            ]);
    }

    /**
     * @Route("/register", name="app-register")
     */
    public function show_registerPage(Connection $connection, Request $request)
    {
        $loginBundle = $this->signIn_as_customer();
        $loginForm = $loginBundle[1];
        $loginHandler = $this->handleSignIn_as_customer($connection, $request, $loginForm, $loginBundle[0]);

        $registrationBundle = $this->signUp_as_customer();
        $registrationForm = $registrationBundle[1];
        $registrationHandler = $this->handleSignUp_as_customer($connection, $request, $registrationForm, $registrationBundle[0]);

        $feedback = "";
        if($loginHandler && $loginHandler !== "Invalid") {
            return $loginHandler;
        }
        else if($loginHandler === "Invalid") {
            $feedback = "Login Unsuccessful";
        }
        elseif ($registrationHandler) {
            return $registrationHandler;
        }

        return $this->render('home/register.html.twig', [
            "registration" => $registrationForm->createView(),
            'login' => $loginForm->createView(),
            'feedback' => $feedback
        ]);
    }

    public function order(Connection $connection, Request $request)
    {
        $loginBundle = $this->signIn_as_customer();
        $loginForm = $loginBundle[1];
        $loginHandler = $this->handleSignIn_as_customer($connection, $request, $loginForm, $loginBundle[0]);

        $feedback = "";
        if($loginHandler && $loginHandler !== "Invalid") {
            return $loginHandler;
        }
        else if($loginHandler === "Invalid") {
            $feedback = "Login Unsuccessful";
        }

        //////////////////////////////////////////////////////////////////////////////////////
        $package = new Package();
        $packageForm = $this->createForm(PackageForm::class, $package);
        //////////////////////////////////////////////////////////////////////////////////////


        return $this->render('home/order.html.twig', 
        ['package' => $packageForm->createView(),
        'feedback' => $feedback,
        'login' => $loginForm->createView()]);
    }


    public function track_view(Connection $connection, Request $request)
    {

        $data = [];
        $status = [];

        $loginBundle = $this->signIn_as_customer();
        $loginForm = $loginBundle[1];
        $loginHandler = $this->handleSignIn_as_customer($connection, $request, $loginForm, $loginBundle[0]);

        $trackingBundle = $this->tracking();
        $trackingForm = $trackingBundle[1];
        $trackingHandler = $this->handleTracking($request, $trackingForm, $trackingBundle[0]);  

        $feedback = "";
        if($loginHandler && $loginHandler !== "Invalid") {
            return $loginHandler;
        }
        else if($loginHandler === "Invalid") {
            $feedback = "Login Unsuccessful";
        }
        else if($trackingHandler) {
            return $trackingHandler;
        }

        return $this->render('home/track.html.twig', [
            'tracking' => $trackingForm->createView(),
            'login' => $loginForm->createView(), 
            'data' => $data,
            'feedback' => $feedback,
            'id' => $trackingBundle[0]->getPackageID(),
            'status' =>$status
            ]);
    }

    public function track_view_id(Connection $connection, Request $request, $id)
    {
        $data = $this->trackingQuery($connection, $id);
        $status = $this->statusQuery($connection, $id);

        $loginBundle = $this->signIn_as_customer();
        $loginForm = $loginBundle[1];
        $loginHandler = $this->handleSignIn_as_customer($connection, $request, $loginForm, $loginBundle[0]);

        $trackingBundle = $this->tracking($id);
        $trackingForm = $trackingBundle[1];
        $trackingHandler = $this->handleTracking($request, $trackingForm, $trackingBundle[0]);  

        $feedback = "";
        if($loginHandler && $loginHandler !== "Invalid") {
            return $loginHandler;
        }
        else if($loginHandler === "Invalid") {
            $feedback = "Login Unsuccessful";
        }
        else if($trackingHandler) {
            return $trackingHandler;
        }

        return $this->render('home/trackid.html.twig', [
            'tracking' => $trackingForm->createView(),
            'login' => $loginForm->createView(), 
            'data' => $data,
            'feedback' => $feedback,
            'id' => $trackingBundle[0]->getPackageID(),
            'status' =>$status
            ]);
    }




    public function employee_home(Connection $connection, Request $request)
    {
        $session = $this->get('session');
        if ($session->has('user') && $session->get('user')['type'] == 'employee')  
        {
            return $this->employee_dashboard($connection, $request);
            
        } 
        elseif ($session->has('user') && $session->get('user')['type'] != 'employee'){
            $session->clear();
            return $this->login($connection, $request);
        }
        else {

            return $this->login($connection, $request);
        }

    }


    public function employee_login(Connection $connection, Request $request) {

        $loginBundle = $this->signIn_as_customer();
        $loginForm = $loginBundle[1];
        $loginHandler = $this->handleSignIn_as_customer($connection, $request, $loginForm, $loginBundle[0]);

        $employeeBundle = $this->signIn_as_employee();
        $employeeForm = $employeeBundle[1];
        $employeeHandler = $this->handleSignIn_as_employee($connection, $request, $employeeForm, $employeeBundle[0]);

        $userdata = "";
        $feedback = "";
        if($loginHandler && $loginHandler !== "Invalid") {
            return $loginHandler;
        }
        else if($loginHandler === "Invalid") {
            $feedback = "Login Unsuccessful";
        }
        elseif ($employeeHandler) {
            return $employeeHandler;
        } else if ($employeeHandler === FALSE) {
            $userdata = "Login unsuccessful.";
        }

        return $this->render('home/portal.html.twig', [
            'login' => $loginForm->createView(), 
            'portal'=>$employeeForm->createView(),
            'feedback2'=>$userdata,
            'feedback'=>$feedback
        ]);
    }
        
    /**
     * @Route("/careers", name="app-careers")
     */
    public function careers(Connection $connection, Request $request){

        $loginBundle = $this->signIn_as_customer();
        $loginForm = $loginBundle[1];
        $loginHandler = $this->handleSignIn_as_customer($connection, $request, $loginForm, $loginBundle[0]);

        $feedback = "";
        if($loginHandler && $loginHandler !== "Invalid") {
            return $loginHandler;
        }
        else if($loginHandler === "Invalid") {
            $feedback = "Login Unsuccessful";
        }

        $jobs = [
            '001'=>['Office'=>'AUS001', 'Position'=>'Courier', 'Details'=>'Manage and deliver packages.'],
            '002'=>['Office'=>'HOU002', 'Position'=>'Courier', 'Details'=>'Manage and deliver packages.'],
            '003'=>['Office'=>'ATL001', 'Position'=>'Courier', 'Details'=>'Manage and deliver packages.']];
        return $this->render('employee/careers.html.twig',[
            'login' => $loginForm->createView(),
            'feedback'=> $feedback
        ]);
    }

    /**
     * @Route("/careers/apply", name="app-employee-register")
    */
    public function apply(Connection $connection, Request $request) {

        $loginBundle = $this->signIn_as_customer();
        $loginForm = $loginBundle[1];
        $loginHandler = $this->handleSignIn_as_customer($connection, $request, $loginForm, $loginBundle[0]);

        $feedback = "";
        if($loginHandler && $loginHandler !== "Invalid") {
            return $loginHandler;
        }
        else if($loginHandler === "Invalid") {
            $feedback = "Login Unsuccessful";
        }

        $registration = new Registration();
        $all_offices = $this->getAllOfficeQuery($connection);
        $listing = [];

        foreach ($all_offices as $office) {
            array_push($listing, [$office['office'] => $office['office']]);
        }
        $registrationForm = $this->createFormBuilder($registration)
            ->add('FName', TextType::class, ['label' => '* First Name ',  'required' => true])
            ->add('MInit', TextType::class, ['label' => '* Middle Initial ',  'required' => true])
            ->add('LName', TextType::class, ['label' => '* Last Name ',  'required' => true])
            ->add('Password', PasswordType::class, ['label' => '* Password ',  'required' => true])
            ->add('Office', ChoiceType::class, ['label' => '* Office ', 'choices'=>$listing, 'required' => true])
            ->add('Submit', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

        $registrationForm->handleRequest($request);
        
        $hp ="";
        if($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $registration = $registrationForm->getData();
            $hp = $this->registerEmployeeQuery($connection, $registration);
            $this->get('session')->getFlashBag()->add('registration-type', 'Employee');
            $this->get('session')->getFlashBag()->add('registration-id', $hp);

            return $this->redirectToRoute('app-registration-complete');
        }  
        return $this->render('employee/apply.html.twig', [
            'employee_id'=>$hp, 
            'feedback'=>$feedback,
            'login' => $loginForm->createView(), 
            'registration' => $registrationForm->createView()]);
    }

}