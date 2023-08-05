<?php

namespace App\Repository;

use App\Entity\Intermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Intermission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intermission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intermission[]    findAll()
 * @method Intermission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intermission::class);
    }

    // /**
    //  * @return Intermission[] Returns an array of Intermission objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Intermission
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
