<?php

namespace App\Repository;

use App\Entity\Regel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Regel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Regel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Regel[]    findAll()
 * @method Regel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Regel::class);
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function listAll(PaginatorInterface $paginator, Request $request)
    {
        $dql = $this->createQueryBuilder('r')
            ->getQuery()
        ;
        return $paginator->paginate(
            $dql, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
    }

    // /**
    //  * @return Regel[] Returns an array of Regel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Regel
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
