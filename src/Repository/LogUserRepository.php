<?php

namespace App\Repository;

use App\Entity\LogUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LogUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogUser[]    findAll()
 * @method LogUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogUser::class);
    }
}
