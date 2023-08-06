<?php

namespace App\Repository;

use App\Entity\Tuning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tuning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tuning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tuning[]    findAll()
 * @method Tuning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TuningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tuning::class);
    }
}
