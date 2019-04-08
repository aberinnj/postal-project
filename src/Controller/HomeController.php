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

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Doctrine\DBAL\Driver\Connection;

class HomeController extends RootController {
    


    /**
     * @Route("/", name="app-home")
     */
    public function home_display_view(Connection $connection, Request $request)
    {
        $loginForm = $this->customer($connection, $request);

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

        return $this->render('home/home.html.twig', ['tracking' => $trackingForm->createView(), 'login' => $loginForm->createView()]);
    }

    /**
     * @Route("/register", name="app-register")
     */
    public function register_view(Connection $connection, Request $request)
    {
        $loginForm = $this->customer($connection, $request);

        $registration = new Registration();
        $registrationForm = $this->createForm(CustomerRegistrationForm::class, $registration);
            
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $registration = $registrationForm->getData();

            $this->registerQuery($connection, $registration);
            return $this->redirectToRoute('app-home');
        }

        return $this->render('home/register.html.twig', [
            "registration" => $registrationForm->createView(),
            'login' => $loginForm->createView()
        ]);
    }

    /**
     * @Route("/order", name="app-ship-order")
     */
    public function order_view(Connection $connection, Request $request)
    {
        $loginForm = $this->customer($connection, $request);

        $package = new Package();
        $packageForm = $this->createForm(PackageForm::class, $package);

        $packageForm->handleRequest($request);

        return $this->render('home/order.html.twig', 
        ['package' => $packageForm->createView(),
        'login' => $loginForm->createView()]);
    }

    /**
     * @Route("/track", name="app-track")
     */
    public function track_view(Connection $connection, Request $request)
    {

        $credentials = new Credentials();
        $credentialsForm = $this->createForm(CustomerLoginForm::class, $credentials);

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
            'login' => $credentialsForm->createView(), 
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