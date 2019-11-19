<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[]
     */
    public function findAllPublishedOrderedByNewest(): array
    {
        return $this->addIsPublishedQueryBuilder()
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?: $this->createQueryBuilder('a');
    }

    private function addIsPublishedQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder($qb)->andWhere('a.publishedAt IS NOT NULL');
    }
}
