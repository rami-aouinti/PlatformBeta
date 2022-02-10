<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function list(PaginatorInterface $paginator, Request $request, User $user)
    {
        $dql = $this->createQueryBuilder('t')
            ->andWhere("t.user = :user")
            ->setParameter("user", $user)
            ->getQuery()
        ;
        return $paginator->paginate(
            $dql, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function listAll(PaginatorInterface $paginator, Request $request)
    {
        $dql = $this->createQueryBuilder('t')
            ->getQuery()
        ;
        return $paginator->paginate(
            $dql, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
