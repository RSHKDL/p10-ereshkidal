<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
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
     * @throws \Exception
     */
    public function findAllPublishedOrderedByNewest(): array
    {
        return $this->addIsPublishedQueryBuilder()
            ->leftJoin('a.tags', 't')
            ->addSelect('t')
            ->leftJoin('a.comments', 'c')
            ->addSelect('c')
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?: $this->createQueryBuilder('a');
    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     * @throws \Exception
     */
    private function addIsPublishedQueryBuilder(QueryBuilder $qb = null): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder($qb)
            ->andWhere('a.publishedAt IS NOT NULL')
            ->andWhere('a.publishedAt <= :now')
            ->setParameter('now', new \DateTime());
    }

    /**
     * @param Article $article
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Article $article): void
    {
        $this->_em->persist($article);
        $this->_em->flush();
    }

    /**
     * @param Article $article
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Article $article): void
    {
        $this->_em->flush($article);
    }

    /**
     * @todo this concern comments and should be moved to CommentRepository
     * @return Criteria
     */
    public static function createNonDeletedCriteria(): Criteria
    {
        $criteria = Criteria::create();

        return $criteria
            ->andWhere(Criteria::expr()->eq('isDeleted', false))
            ->orderBy(['createdAt' => 'DESC']);
    }
}
