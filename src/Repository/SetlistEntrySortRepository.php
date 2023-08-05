<?php

namespace App\Repository;

use App\Entity\SetlistEntrySort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SetlistEntrySort|null find($id, $lockMode = null, $lockVersion = null)
 * @method SetlistEntrySort|null findOneBy(array $criteria, array $orderBy = null)
 * @method SetlistEntrySort[]    findAll()
 * @method SetlistEntrySort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SetlistEntrySortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SetlistEntrySort::class);
    }

    // /**
    //  * @return SetlistEntrySort[] Returns an array of SetlistEntrySort objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SetlistEntrySort
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
