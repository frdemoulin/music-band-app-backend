<?php

namespace App\Repository;

use App\Entity\BankingOperationSort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BankingOperationSort|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankingOperationSort|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankingOperationSort[]    findAll()
 * @method BankingOperationSort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankingOperationSortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankingOperationSort::class);
    }

    // /**
    //  * @return BankingOperationSort[] Returns an array of BankingOperationSort objects
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
    public function findOneBySomeField($value): ?BankingOperationSort
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
