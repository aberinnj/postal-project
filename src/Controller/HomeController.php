<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="app-home")
     */
    public function display()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/support", name="app-support")
     */
    public function help()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/login", name="app-login")
     */
    public function sign()
    {
        return $this->render('home/login.html.twig');
    }
}