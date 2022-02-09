<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $userPasswordEncoder;


    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $now = new \DateTime();

        $user = new User();
        $user->setEmail("rami.aouinti@gmail.com");
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, "19891989aA"));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $profile = new Profile();
        $profile->setFirstname('Mohamed Rami');
        $profile->setLastname('Aouinti');
        $profile->setEmail('rami.aouinti@gmail.com');
        $profile->setActive(true);
        $profile->setBirthday($now);
        $profile->setCountry('Germany');
        $profile->setNationality('Tunesisch');
        $profile->setState('Müncchen');
        $profile->setTelefone('017635587613');
        $profile->setPostcode(85375);
        $profile->setStreet('Vogelweide');
        $profile->setHomenumber('4b');
        $profile->setUser($user);
        $profile->setImage('image.png');
        $profile->setStart($now);
        $profile->setEnd($now);
        $manager->persist($profile);


        $manager->flush();
    }
}
