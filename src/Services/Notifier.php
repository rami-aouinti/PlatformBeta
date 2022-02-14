<?php

namespace App\Services;

use App\Entity\Article;
use App\Entity\NotificationType;
use App\Repository\NotificationRepository;
use App\Repository\UserNotificationRepository;
use App\Repository\UserRepository;
use App\Services\Notification\Factory\NotificationFactory;
use App\Services\UserNotification\Factory\UserNotificationFactory;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class that allows to publish an Update object.
 */
class Notifier
{
    /**
     * @var NotificationFactory
     */
    private $notificationFactory;

    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserNotificationFactory
     */
    private $userNotificationFactory;

    /**
     * @var UserNotificationRepository
     */
    private $userNotificationRepository;

    public function __construct(
        NotificationFactory $notificationFactory,
        NotificationRepository $notificationRepository,
        SerializerInterface $serializer,
        UserRepository $userRepository,
        UserNotificationFactory $userNotificationFactory,
        UserNotificationRepository $userNotificationRepository
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->notificationRepository = $notificationRepository;
        $this->serializer = $serializer;
        $this->userRepository = $userRepository;
        $this->userNotificationFactory = $userNotificationFactory;
        $this->userNotificationRepository = $userNotificationRepository;
    }

    /**
     * When an article is created, the app will notify all users that are connected.
     */
    public function articleCreated(Article $article, PublisherInterface $publisher)
    {
        $notification = $this->notificationFactory->create($article, NotificationType::ARTICLE_CREATED);
        $this->notificationRepository->save($notification);

        $jsonContent = $this->serializer->serialize($notification, 'json', ['groups' => ['normal']]);

        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            $userNotification = $this->userNotificationFactory->create($notification, $user);
            $this->userNotificationRepository->persist($userNotification);
        }

        $this->userNotificationRepository->flush();

        $update = new Update(
            'http://localhost/new/article',
            $jsonContent
        );

        $publisher($update);
    }
}
