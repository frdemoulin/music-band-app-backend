<?php

namespace App\Repository;

use App\Entity\BackingTrackSort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BackingTrackSort|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackingTrackSort|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackingTrackSort[]    findAll()
 * @method BackingTrackSort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackingTrackSortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackingTrackSort::class);
    }

    /**
     * @return BackingTrackSort[] Returns an array of all BackingTrackSort names
     */
    public function getAllBackingTrackSortNames()
    {
        $query = $this->createQueryBuilder('b')
            ->select('b.name')
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        $result = [];

        foreach ($query as $value) {
            $result[] = $value['name'];
        }

        return $result;
    }
}
