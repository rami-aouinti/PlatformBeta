<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Event;
use App\Entity\Image;
use App\Entity\Profile;
use App\Entity\Status;
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
        $user->setUsername('Rami');
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
        $profile->setImage('avatar.png');
        $profile->setStart($now);
        $profile->setEnd($now);
        $manager->persist($profile);


        for ($i = 0; $i < 10; $i++)
        {
            $event = new Event();
            $event->setTitle("Event Number $i");
            $event->setDescription("Event Description $i");
            $event->setStart($now);
            $event->setEnd($now);
            $event->setActive(true);
            $event->setAllDay(true);
            $event->setUrl('url');
            $event->addMember($user);
            $event->setBackgroundColor('000000');
            $event->setBorderColor('00000');
            $manager->persist($event);
        }

        $status = new Status();
        $status->setActive(true);
        $status->setName('Backlog');
        $status->setColor('red');
        $manager->persist($status);

        $status = new Status();
        $status->setActive(true);
        $status->setName('Todo');
        $status->setColor('blue');
        $manager->persist($status);

        $status = new Status();
        $status->setActive(true);
        $status->setName('In Progress');
        $status->setColor('yellow');
        $manager->persist($status);

        $status = new Status();
        $status->setActive(true);
        $status->setName('Waiting for Feedback');
        $status->setColor('black');
        $manager->persist($status);

        $status = new Status();
        $status->setActive(true);
        $status->setName('Done');
        $status->setColor('gray');
        $manager->persist($status);

        $image = new Image();
        $image->setAlt('avatar');
        $manager->persist($image);

            $article = new Article();
            $article->setTitle("Test Article");
            $article->setContent("Test Content");
            $article->setAuthor($user);
            $article->setImage($image);
            $manager->persist($article);


        $manager->flush();
    }
}
