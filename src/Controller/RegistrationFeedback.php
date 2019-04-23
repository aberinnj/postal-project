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

class RegistrationFeedback extends Root_HomeController {

    public function home(Connection $connection, Request $request)
    {
        $session = $this->get('session')->getFlashBag();

        $type = "";
        $id = "";

        if($session->has('registration-type')){
            $type = $session->get('registration-type')[0];
            $id = $session->get('registration-id')[0];
            $session->clear();
        }
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

        return $this->render('home/registered.html.twig', [
            'login' => $loginForm->createView(),
            'regType' => $type,
            'regID' => $id,
            'feedback' => $feedback
        ]);
    }


}