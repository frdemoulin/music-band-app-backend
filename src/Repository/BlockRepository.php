<?php

namespace App\Repository;

use App\Entity\BackingTrack;
use App\Entity\BackingTrackSort;
use App\Entity\Block;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Block|null find($id, $lockMode = null, $lockVersion = null)
 * @method Block|null findOneBy(array $criteria, array $orderBy = null)
 * @method Block[]    findAll()
 * @method Block[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Block::class);
    }

    /**
     * @return Block[] Returns an array of Block objects
     */
    public function findAllBlocksWithTotalDuration()
    {
        $blocks = $this->createQueryBuilder('b')
            ->join('b.blockHasCovers', 'bhc')
            ->join('bhc.cover', 'c')
            // ->join('c.song', 's')
            // ->join('c.intro', 'i')
            // ->join('c.outro', 'o')
            // ->orderBy('s.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return $blocks;
    }

    /**
     *  Retourne les types de BT déjà uploadés pour un bloc donné.
     *
     * @param Block $block Le bloc en question
     *
     * @return BackingTrackSort[] Returns an array of BackingTrackSort names for the given block
     */
    public function getBackingTrackSortNamesAlreadyUploadedForAGivenBlock(Block $block)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin(BackingTrack::class, 'bt', Join::WITH, 'b.id = bt.block')
            ->innerJoin(BackingTrackSort::class, 'bts', Join::WITH, 'bts.id = bt.backingTrackSort')
            ->select('bts.name', 'bt.updatedAt')
            ->andWhere('b.id = :blockId')
            ->setParameter('blockId', $block->getId())
            ->orderBy('bts.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return string Retourne le nombre total de blocs
     */
    public function getBlocksCount()
    {
        $count = $this->createQueryBuilder('b')
            ->select('COUNT(b.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $count;
    }

    /**
     * @return string Retourne le nombre total de covers distincts engagés dans l'ensemble des blocs
     */
    public function getBlocksCoversCount()
    {
        $count = $this->createQueryBuilder('b')
            ->join('b.blockHasCovers', 'bhc')
            ->join('bhc.cover', 'c')
            ->groupBy('bhc.cover')
            ->select('COUNT(bhc.cover)')
            ->getQuery()
            ->getScalarResult()
        ;

        return \count($count);
    }

    /**
     * @return BackingTrackSort[] Returns an array of BackingTrackSort names for a given block
     */
    public function getBackingTrackSortNames()
    {
        $query = $this->createQueryBuilder('b')
            ->innerJoin(BackingTrack::class, 'bt', Join::WITH, 'b.id = bt.block')
            ->innerJoin(BackingTrackSort::class, 'bts', Join::WITH, 'bts.id = bt.backingTrackSort')
            ->select('bts.name')
            ->orderBy('bts.id', 'ASC')
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
