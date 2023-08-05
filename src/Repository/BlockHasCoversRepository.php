<?php

namespace App\Repository;

use App\Entity\BlockHasCovers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlockHasCovers|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlockHasCovers|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlockHasCovers[]    findAll()
 * @method BlockHasCovers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlockHasCoversRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlockHasCovers::class);
    }

    // /**
    //  * @return BlockHasCovers[] Returns an array of BlockHasCovers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlockHasCovers
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
