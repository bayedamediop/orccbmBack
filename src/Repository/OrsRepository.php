<?php

namespace App\Repository;

use App\Entity\Ors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ors|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ors|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ors[]    findAll()
 * @method Ors[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ors::class);
    }

    // /**
    //  * @return Ors[] Returns an array of Ors objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ors
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
