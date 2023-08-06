<?php

namespace App\Repository;

use App\Entity\AlbumSort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlbumSort|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlbumSort|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlbumSort[]    findAll()
 * @method AlbumSort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumSortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlbumSort::class);
    }

    // /**
    //  * @return AlbumSort[] Returns an array of AlbumSort objects
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
    public function findOneBySomeField($value): ?AlbumSort
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
