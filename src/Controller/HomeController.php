<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function register()
    {
        return $this->render('home/register.html.twig');
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