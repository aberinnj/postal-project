<?php

namespace App\Controller;


use App\Entity\Registration;
use App\Entity\Tracking;
use App\Entity\Package;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\DBAL\Driver\Connection;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="app-home")
     */
    public function home_display(Request $request)
    {
        $tracking = new Tracking();
        $trackingForm = $this->createFormBuilder($tracking)
            ->add('PackageID', TextType::class, [ 'label' => 'Tracking ID '] )
            ->add('Submit', SubmitType::class, [ 'label' => 'Track'] )
            ->getForm();

        $trackingForm->handleRequest($request);
        if ($trackingForm->isSubmitted() && $trackingForm->isValid()) {
            $tracking = $trackingForm->getData();
            $this->get('session')->getFlashBag()->add('trackID', $tracking);
            return $this->redirectToRoute('app-track');
        }

        return $this->render('home/home.html.twig', ['tracking' => $trackingForm->createView()]);
    }

    /**
     * @Route("/register", name="app-register")
     */
    public function register(Connection $connection, Request $request)
    {
        $registration = new Registration();
        $registrationForm = $this->createFormBuilder($registration)
            ->add('Email', TextType::class, ['label' => '* Email ',  'required' => true])
            ->add('Password', PasswordType::class, ['label' => '* Password ',  'required' => true])
            ->add('FName', TextType::class, ['label' => '* First Name ',  'required' => true])
            ->add('MInit', TextType::class, ['label' => '* Middle Initial ',  'required' => true])
            ->add('LName', TextType::class, ['label' => '* Last Name ',  'required' => true])
            ->add('Street', TextType::class, ['label' => '* Street Address ',  'required' => true])
            ->add('ApartmentNo', NumberType::class, ['label' => 'Apartment No. ', 'required' => false])
            ->add('City', TextType::class, ['label' => '* City ',  'required' => true])
            ->add('State', ChoiceType::class, ['label'=> '* State ','choices' => [
                'Alabama'=>'AL',
                'Alaska'=>'AK',
                'Arizona'=>'AZ',
                'Arkansas'=>'AR',
                'California'=>'CA',
                'Colorado'=>'CO',
                'Connecticut'=>'CT',
                'Delaware'=>'DE',
                'Florida'=>'FL',
                'Georgia'=>'GA',
                'Hawaii'=>'HI',
                'Idaho'=>'ID',
                'Illinois'=>'IL',
                'Indiana'=>'IN',
                'Iowa'=>'IA',
                'Kansas'=>'KS',
                'Kentucky'=>'KY',
                'Louisiana'=>'LA',
                'Maine'=>'ME',
                'Maryland'=>'MD',
                'Massachusetts'=>'MA',
                'Michigan'=>'MI',
                'Minnesota'=>'MN',
                'Mississippi'=>'MS',
                'Missouri'=>'MO',
                'Montana'=>'MT',
                'Nebraska'=>'NE',
                'Nevada'=>'NV',
                'New Hampshire'=>'NH',
                'New Jersey'=>'NJ',
                'New Mexico'=>'NM',
                'New York'=>'NY',
                'North Carolina'=>'NC',
                'North Dakota'=>'ND',
                'Ohio'=>'OH',
                'Oklahoma'=>'OK',
                'Oregon'=>'OR',
                'Pennsylvania'=>'PA',
                'Rhode Island'=>'RI',
                'South Carolina'=>'SC',
                'South Dakota'=>'SD',
                'Tennessee'=>'TN',
                'Texas'=>'TX',
                'Utah'=>'UT',
                'Vermont'=>'VT',
                'Virginia'=>'VA',
                'Washington'=>'WA',
                'West Virginia'=>'WV',
                'Wisconsin'=>'WI',
                'Wyoming'=>'WY'
            ],  'required' => true])
            ->add('ZIP', NumberType::class, ['label' => '* ZIP Code ',  'required' => true])
            ->add('Submit', SubmitType::class, ['label' => 'Submit'])
            ->getForm();
            
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $registration = $registrationForm->getData();

            $this->registerQuery($connection, $registration);
            return $this->redirectToRoute('app-home');
        }

        return $this->render('home/register.html.twig', [
            "registration" => $registrationForm->createView(),
        ]);
    }

    /*******************************************************************************
    *******************************************************************************/
    private function registerQuery(Connection $connection, Registration $registration) {

        try{
            
            $customer_sql = "INSERT INTO customer (FName, MInit, LName, Email, State, City, ZIP, Street, ApartmentNo)
            VALUES (:FName, :MInit, :LName, :Email, :State, :City, :ZIP, :Street, :ApartmentNo)";

            $customer_credentials_sql = "INSERT INTO customercredentials (Email, Password)
            VALUES ((SELECT cust.Email FROM customer as cust where cust.Email=:Email), :Password)";

            $stmt = $connection->prepare($customer_sql);
            $stmt->bindValue(':FName', $registration->getFName());
            $stmt->bindValue(':MInit', $registration->getMInit());
            $stmt->bindValue(':LName', $registration->getLName());
            $stmt->bindValue(':Email', $registration->getEmail());
            $stmt->bindValue(':State', $registration->getState());
            $stmt->bindValue(':City', $registration->getCity());
            $stmt->bindValue(':ZIP', $registration->getZIP());
            $stmt->bindValue(':Street', $registration->getStreet());
            $stmt->bindValue(':ApartmentNo', $registration->getApartmentNo());
            $stmt->execute();

            $stmt = $connection->prepare($customer_credentials_sql);
            $stmt->bindValue(':Email', $registration->getEmail());
            $stmt->bindValue(':Password', $registration->getPassword());
            $stmt->execute();

            $stmt = null;
        } catch (PODException $e){ 

            echo "Error " . $e->getMessage();
        }
    }

    /**
     * @Route("/employee-portal", name="app-employee-login")
     */
    public function login()
    {
        return $this->render('home/portal.html.twig');
    }

    /**
     * @Route("/order", name="app-ship-order")
     */
    public function order()
    {
        $package = new Package();
        $packageForm = $this->createFormBuilder($package)
        ->add('Email', TextType::class, ['label' => '* Email ',  'required' => true])
        ->add('Recipient', TextType::class, ['label' => '* Recipient Name ',  'required' => true])
        ->add('Weight', NumberType::class, ['label' => '* Weight ',  'required' => true])
        ->add('Length', NumberType::class, ['label' => '* Length ',  'required' => true])
        ->add('Width', NumberType::class, ['label' => '* Width ',  'required' => true])
        ->add('Height', NumberType::class, ['label' => '* Height ',  'required' => true])
        ->add('Street', TextType::class, ['label' => '* Street Address ', 'required' => true])
        ->add('ApartmentNo', NumberType::class, ['label' => 'Apartment No. ', 'required' => false])
        ->add('City', TextType::class, ['label' => '* City ',  'required' => true])
        ->add('State', ChoiceType::class, ['label'=> '* State ','choices' => [
            'Alabama'=>'AL',
            'Alaska'=>'AK',
            'Arizona'=>'AZ',
            'Arkansas'=>'AR',
            'California'=>'CA',
            'Colorado'=>'CO',
            'Connecticut'=>'CT',
            'Delaware'=>'DE',
            'Florida'=>'FL',
            'Georgia'=>'GA',
            'Hawaii'=>'HI',
            'Idaho'=>'ID',
            'Illinois'=>'IL',
            'Indiana'=>'IN',
            'Iowa'=>'IA',
            'Kansas'=>'KS',
            'Kentucky'=>'KY',
            'Louisiana'=>'LA',
            'Maine'=>'ME',
            'Maryland'=>'MD',
            'Massachusetts'=>'MA',
            'Michigan'=>'MI',
            'Minnesota'=>'MN',
            'Mississippi'=>'MS',
            'Missouri'=>'MO',
            'Montana'=>'MT',
            'Nebraska'=>'NE',
            'Nevada'=>'NV',
            'New Hampshire'=>'NH',
            'New Jersey'=>'NJ',
            'New Mexico'=>'NM',
            'New York'=>'NY',
            'North Carolina'=>'NC',
            'North Dakota'=>'ND',
            'Ohio'=>'OH',
            'Oklahoma'=>'OK',
            'Oregon'=>'OR',
            'Pennsylvania'=>'PA',
            'Rhode Island'=>'RI',
            'South Carolina'=>'SC',
            'South Dakota'=>'SD',
            'Tennessee'=>'TN',
            'Texas'=>'TX',
            'Utah'=>'UT',
            'Vermont'=>'VT',
            'Virginia'=>'VA',
            'Washington'=>'WA',
            'West Virginia'=>'WV',
            'Wisconsin'=>'WI',
            'Wyoming'=>'WY'
        ],  'required' => true])
        ->add('ZIP', NumberType::class, ['label' => '* ZIP Code ',  'required' => true])
        ->add('Priority', NumberType::class, ['label' => '* Priority '])
        ->add('isFragile', CheckboxType::class, ['label' => 'isFragile? ', 'required' => false])
        ->add('Submit', SubmitType::class, ['label' => 'Submit'])
        ->getForm();

        return $this->render('home/order.html.twig', ['package' => $packageForm->createView()]);
    }

    /**
     * @Route("/track", name="app-track")
     */
    public function track(Connection $connection, Request $request)
    {

        $tracking = new Tracking();

        $bag = $this->get('session')->getFlashBag();
        $data = [];
        $status = [];
        if ($bag->has('trackID')) {

            $req = $bag->get('trackID');
            $tracking = $req[0];

            $data = $this->trackingQuery($connection, $req[0]);
            $status = $this->statusQuery($connection, $req[0]);
        }

        $trackingForm = $this->createFormBuilder($tracking)
        ->add('PackageID', TextType::class, [ 'label' => 'Tracking ID '] )
        ->add('Submit', SubmitType::class, [ 'label' => 'Track'] )
        ->getForm();
        $trackingForm->handleRequest($request);

        if ($trackingForm->isSubmitted() && $trackingForm->isValid()) {
            $tracking = $trackingForm->getData();
            $this->get('session')->getFlashBag()->add('trackID', $tracking);
            return $this->redirectToRoute('app-track');
        }
    

        return $this->render('home/track.html.twig', [
            'tracking' => $trackingForm->createView(), 
            'data' => $data,
            'id' => $tracking->getPackageID(),
            'status' =>$status]);
    }

    private function trackingQuery(Connection $connection, Tracking $tracking): array {

        try{
            $sql = "SELECT DISTINCT t.Update_Date as Date, t.TrackingNote as Note FROM tracking as t, package as p WHERE t.Package_ID = :pID ORDER BY t.Tracking_Index ASC";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':pID', strval($tracking->getPackageID()));
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    private function statusQuery(Connection $connection, Tracking $tracking) {
        try{
            $sql = "SELECT DISTINCT s.Status as Status FROM package as p, status as s WHERE p.PackageID = :pID AND p.Status = s.Code";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':pID', strval($tracking->getPackageID()));
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }
}