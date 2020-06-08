<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return User[]
     */
    public function findAllUsernameAlphabetical(): array
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.username', 'ASC')
            ->getQuery()
            ->execute();
    }

    /**
     * @param string $query
     * @param int $limit
     * @return User[]
     */
    public function findAllMatching(string $query, int $limit = 5): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :query OR u.email LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string|null $term
     * @return QueryBuilder
     */
    public function getQueryBuilderWithFilter(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('u');

        if ($term) {
            $qb->andWhere('u.username LIKE :term OR u.email LIKE :term');
            $qb->setParameter('term', '%' . $term . '%');
        }

        return $qb->orderBy('u.username', 'ASC');
    }
}
