<?php

namespace App\Repository;

use App\Entity\AbstractReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AbstractReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractReport[]    findAll()
 * @method AbstractReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractReport::class);
    }

    /**
     * @param AbstractReport $report
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(AbstractReport $report): void
    {
        $this->_em->persist($report);
        $this->_em->flush();
    }
}
