<?php

namespace App\Repository;

use App\Entity\TraductionTarget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TraductionTarget|null find($id, $lockMode = null, $lockVersion = null)
 * @method TraductionTarget|null findOneBy(array $criteria, array $orderBy = null)
 * @method TraductionTarget[]    findAll()
 * @method TraductionTarget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraductionTargetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TraductionTarget::class);
    }

    // /**
    //  * @return TraductionTarget[] Returns an array of TraductionTarget objects
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
    public function findOneBySomeField($value): ?TraductionTarget
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
