<?php

namespace App\Twig;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * This extension creates a global variable of number of notification for the current user.
 */
class UserExtension
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var TokenStorageInterface
     */
    private TokenStorageInterface $tokenStorage;

    public function __construct(UserRepository $userRepository, TokenStorageInterface $tokenStorage)
    {
        $this->userRepository = $userRepository;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Returns unread users to the twig global variable 'users'.
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->userRepository->findAll();
    }
}
