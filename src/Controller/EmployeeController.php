<?php

namespace App\Controller;

use App\Entity\Tracking;
use App\Entity\Package;
use App\Entity\Credentials;
use App\Entity\Registration;
use App\Form\EmployeeLoginForm;
use App\Form\CustomerLoginForm;
use App\Form\EmployeeRegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

use Doctrine\DBAL\Driver\Connection;

class EmployeeController extends RootController {

    public function home(Connection $connection, Request $request)
    {
        $session = $this->get('session');
        if ($session->has('user'))  
        {
            return $this->employee_dashboard($connection, $request);
            
        } else {

            return $this->login($connection, $request);
        }

    }

    public function employee_dashboard(Connection $connection, Request $request) {
        $session = $this->get('session');
        $user = $session->get('user');
        
        return $this->render('employee_layout.html.twig', ['id'=>$user['id'], 'type'=>$user['type']]);
    } 

    public function login(Connection $connection, Request $request) {
        $session = $this->get('session');

        $loginForm = $this->customer($connection, $request);

        $employees_credentials = new Credentials();
        $employees_credentialsForm = $this->createForm(EmployeeLoginForm::class, $employees_credentials);
        $employees_credentialsForm->handleRequest($request);

        if($employees_credentialsForm->isSubmitted() && $employees_credentialsForm->isValid()) {
            $employees_credentials = $employees_credentialsForm->getData();

            $pw = $this->EmployeeUserQuery($connection, $employees_credentials);

            if (!empty($pw) && $this->passmatch($employees_credentials, $pw[0]['password'])) {

                $session->set('user', ['id'=>$employees_credentials->getEmployeeID(),
                'type'=>'employee']);

                return $this->redirectToRoute('app-employee-home');
            }

        }
        
        return $this->render('home/portal.html.twig', ['login' => $loginForm->createView(), 'portal'=>$employees_credentialsForm->createView()]);
    }

    // 
    private function EmployeeUserQuery(Connection $connection, Credentials $credentials) {
        try{
            $sql = "SELECT e.Password as password FROM employeecredentials as e WHERE e.EmployeeID = :employeeID";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':employeeID', $credentials->getEmployeeID());
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }
        
    /**
     * @Route("/careers", name="app-careers")
     */
    public function careers(Connection $connection, Request $request)
    {
        $loginForm = $this->customer($connection, $request);

        return $this->render('employee/careers.html.twig',
        ['login' => $loginForm->createView()]);
    }

    /**
     * @Route("/careers/apply", name="app-employee-register")
    */
    public function apply(Connection $connection, Request $request) {
        $loginForm = $this->customer($connection, $request);

        $registration = new Registration();
        $registrationForm = $this->createForm(EmployeeRegistrationForm::class, $registration);

        $registrationForm->handleRequest($request);
        if($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $registration = $registrationForm->getData();

            $hp = $this->registerUserQuery($connection, $registration);
            return $this->redirectToRoute('app-employee-home');
        }
        
        return $this->render('employee/apply.html.twig', ['login' => $loginForm->createView(), 'registration' => $registrationForm->createView()]);
    }
}