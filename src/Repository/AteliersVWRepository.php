<?php

namespace App\Repository;

use App\Entity\AteliersVW;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AteliersVW|null find($id, $lockMode = null, $lockVersion = null)
 * @method AteliersVW|null findOneBy(array $criteria, array $orderBy = null)
 * @method AteliersVW[]    findAll()
 * @method AteliersVW[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AteliersVWRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AteliersVW::class);
    }

    // /**
    //  * @return AteliersVW[] Returns an array of AteliersVW objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AteliersVW
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
