<?php

namespace App\Repository;

use App\Entity\Timework;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
