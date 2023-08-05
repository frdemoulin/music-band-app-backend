<?php

namespace App\Repository;

use App\Entity\IntroOutro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IntroOutro|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntroOutro|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntroOutro[]    findAll()
 * @method IntroOutro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntroOutroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IntroOutro::class);
    }

    /**
     * @return string Retourne le nombre total d'intros / outros
     */
    public function getIntrosOutrosCount()
    {
        $count = $this->createQueryBuilder('io')
            ->select('COUNT(io.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $count;
    }

    // /**
    //  * @return IntroOutro[] Returns an array of IntroOutro objects
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
    public function findOneBySomeField($value): ?IntroOutro
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
