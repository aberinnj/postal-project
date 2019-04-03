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
     * @Route("/login", name="app-login")
     */
    public function sign_in()
    {
        return $this->render('home/login.html.twig');
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
        return $this->render('home/track.html.twig');
    }

    /**
     * @Route("/track/{id}", name="app-track-id")
     */
    public function track_id()
    {
        return $this->render('home/track-result.html.twig', [ 'trackingID' => id ]);
    }
}