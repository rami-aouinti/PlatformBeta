<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/uses")
 */
class UserSettingsController extends AbstractController
{
    /**
     * @var Security
     */
    private Security $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/user_profile", name="user_profile")
     */
    public function show(UserRepository $userRepository): Response
    {
        return $this->render('blog/user/profile/show.html.twig', [
            'user' => $this->security->getUser(),
        ]);
    }
}
