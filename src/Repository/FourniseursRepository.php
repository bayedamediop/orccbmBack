<?php

namespace App\Repository;

use App\Entity\Fourniseurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fourniseurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fourniseurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fourniseurs[]    findAll()
 * @method Fourniseurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FourniseursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fourniseurs::class);
    }

    // /**
    //  * @return Fourniseurs[] Returns an array of Fourniseurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fourniseurs
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
