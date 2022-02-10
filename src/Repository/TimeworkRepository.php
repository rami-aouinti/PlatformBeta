<?php

namespace App\Repository;

use App\Entity\Timework;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Timework|null find($id, $lockMode = null, $lockVersion = null)
 * @method Timework|null findOneBy(array $criteria, array $orderBy = null)
 * @method Timework[]    findAll()
 * @method Timework[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timework::class);
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
    //  * @return Timework[] Returns an array of Timework objects
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
    public function findOneBySomeField($value): ?Timework
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
