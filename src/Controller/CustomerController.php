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

use Doctrine\DBAL\Driver\Connection;

class CustomerController extends RootController {

}