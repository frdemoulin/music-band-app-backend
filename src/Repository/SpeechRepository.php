<?php

namespace App\Repository;

use App\Entity\Speech;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Speech|null find($id, $lockMode = null, $lockVersion = null)
 * @method Speech|null findOneBy(array $criteria, array $orderBy = null)
 * @method Speech[]    findAll()
 * @method Speech[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpeechRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Speech::class);
    }

    // /**
    //  * @return Speech[] Returns an array of Speech objects
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
    public function findOneBySomeField($value): ?Speech
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
