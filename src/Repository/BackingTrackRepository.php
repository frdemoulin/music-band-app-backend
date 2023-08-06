<?php

namespace App\Repository;

use App\Entity\BackingTrack;
use App\Entity\BackingTrackSort;
use App\Entity\Block;
use App\Entity\Cover;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BackingTrack|null find($id, $lockMode = null, $lockVersion = null)
 * @method BackingTrack|null findOneBy(array $criteria, array $orderBy = null)
 * @method BackingTrack[]    findAll()
 * @method BackingTrack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BackingTrackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackingTrack::class);
    }

    /**
     * @return string Retourne le nombre total de backing tracks
     */
    public function getBackingTracksCount()
    {
        $count = $this->createQueryBuilder('bt')
            ->select('COUNT(bt.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $count;
    }

    /**
     * @return string Retourne le nombre total de backing tracks engagées dans l'ensemble des blocs
     */
    public function getBlocksBackingTracksCount()
    {
        $count = $this->createQueryBuilder('bt')
            ->andWhere('bt.block IS NOT NULL')
            ->select('COUNT(bt.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $count;
    }

    /**
     * @return string Retourne le nombre total de backing tracks engagées dans l'ensemble des covers
     */
    public function getBackingTracksInCoversCount()
    {
        $count = $this->createQueryBuilder('bt')
            ->andWhere('bt.cover IS NOT NULL')
            ->select('COUNT(bt.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $count;
    }

    /**
     * @return BackingTrackSort[] Returns an array of BackingTrackSort names for a given cover
     */
    public function getBackingTrackByBlockAndBackingTrackSort(Block $block, BackingTrackSort $backingTrackSort)
    {
        // $conn = $this->getEntityManager()->getConnection();

        // $sql = "SELECT * FROM `backing_track` WHERE `backingTrackSort_id` = :backingTrackSort_id AND `block_id` = :block_id";
        // $stmt = $conn->prepare($sql);
        // $stmt->executeStatement([
        //     'block_id' => $block->getId(),
        //     'backingTrackSort_id' => $backingTrackSort->getId()
        // ]);

        // return $stmt->fetch();

        return $this->createQueryBuilder('bt')
            ->select('bt.filename')
            ->andWhere('bt.block = :block')
            ->andWhere('bt.backingTrackSort = :backingTrackSort')
            ->setParameters(['block' => $block, 'backingTrackSort' => $backingTrackSort])
            ->getQuery()
            ->getScalarResult()
        ;
    }
}
