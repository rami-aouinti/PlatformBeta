<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Message\EmailNotification;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        $message = new EmailNotification('rami.aouinti.dourant@gmail.com', 'Welcome!', 'Registration has been completed.');
        $this->dispatchMessage($message);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
