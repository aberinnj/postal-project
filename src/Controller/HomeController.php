<?php

namespace App\Controller;


use App\Entity\Registration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
    public function home_display()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/support", name="app-support")
     */
    public function support_help()
    {
        return $this->render('home/support.html.twig');
    }
    
    /**
     * @Route("/register", name="app-register")
     */
    public function register(Connection $connection, Request $request)
    {
        $registration = new Registration();
        $registrationForm = $this->createFormBuilder($registration)
            ->add('Email', TextType::class, ['label' => 'Email ',  'required' => true])
            ->add('Password', PasswordType::class, ['label' => 'Password ',  'required' => true])
            ->add('FName', TextType::class, ['label' => 'First Name ',  'required' => true])
            ->add('MInit', TextType::class, ['label' => 'Middle Initial ',  'required' => true])
            ->add('LName', TextType::class, ['label' => 'Last Name ',  'required' => true])
            ->add('Street', TextType::class, ['label' => 'Street Address ',  'required' => true])
            ->add('ApartmentNo', NumberType::class, ['label' => 'Apartment No. ', 'required' => false])
            ->add('City', TextType::class, ['label' => 'City ',  'required' => true])
            ->add('State', ChoiceType::class, ['choices' => [
                ''=>null,
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
            ->add('ZIP', NumberType::class, ['label' => 'ZIP Code ',  'required' => true])
            ->add('Submit', SubmitType::class, ['label' => 'Submit'])
            ->getForm();
            
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $registration = $registrationForm->getData();

            $this->registerQuery($connection, $registration);
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
     * @Route("/order", name="app-ship-order")
     */
    public function order()
    {
        return $this->render('home/order.html.twig');
    }

    /**
     * @Route("/track", name="app-track")
     */
    public function track()
    {
        return $this->render('home/track.html.twig', []);
    }
}