<?php

namespace App\Repository;

use App\Entity\Qualites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Qualites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qualites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qualites[]    findAll()
 * @method Qualites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Qualites::class);
    }

    // /**
    //  * @return Qualites[] Returns an array of Qualites objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Qualites
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
