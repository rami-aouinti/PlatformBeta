<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function listAll(PaginatorInterface $paginator, Request $request)
    {
        $dql = $this->createQueryBuilder('p')
            ->orderBy('p.createAt', 'DESC')
            ->getQuery()
        ;
        return $paginator->paginate(
            $dql, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );
    }

    /**
     * List all object with paginator.
     */
    public function paginator(int $page, int $maxResults): Paginator
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->setFirstResult(($page - 1) * $maxResults)
            ->setMaxResults($maxResults)
            ->orderBy('p.createAt', 'DESC');

        return new Paginator($qb);
    }

    public function getArticlesWithComment(): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.comments', 'c')
            ->addSelect('c')
            ->orderBy('a.createAt', 'DESC')
            ->getQuery()->getResult();
    }

    public function countArticles(): string
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function saveNewArticle(Article $article): void
    {
        $this->_em->persist($article);
        $this->_em->flush();
    }

    public function saveExistingArticle(): void
    {
        $this->_em->flush();
    }

    public function remove(Article $article): void
    {
        $this->_em->remove($article);
        $this->_em->flush();
    }
}
