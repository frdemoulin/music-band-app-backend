<?php

namespace App\Repository;

use App\Entity\Block;
use App\Entity\BlockHasCovers;
use App\Entity\Cover;
use App\Entity\Intermission;
use App\Entity\Setlist;
use App\Entity\SetlistEntry;
use App\Entity\Speech;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Setlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Setlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Setlist[]    findAll()
 * @method Setlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SetlistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Setlist::class);
    }

    /**
     * Retourne la durée totale d'une setlist (sans majoration du fait des transitions entre les éléments structurants de la setlist).
     *
     * @return int Durée en secondes
     */
    public function getDurationWithoutTransitionOfAGivenSetlist(Setlist $setlist)
    {
        $coversDuration = $this->createQueryBuilder('s')
            ->innerJoin(SetlistEntry::class, 'se', Join::WITH, 's.id = se.setlist')
            ->innerJoin(Cover::class, 'c', Join::WITH, 'c.id = se.cover')
            ->andWhere('s.id = :setlistId')
            ->select('sum(c.duration)')
            ->setParameter('setlistId', $setlist->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $blocksDuration = $this->createQueryBuilder('s')
            ->innerJoin(SetlistEntry::class, 'se', Join::WITH, 's.id = se.setlist')
            ->innerJoin(Block::class, 'b', Join::WITH, 'b.id = se.block')
            ->andWhere('s.id = :setlistId')
            ->select('sum(b.duration)')
            ->setParameter('setlistId', $setlist->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $intermissionsDuration = $this->createQueryBuilder('s')
            ->innerJoin(SetlistEntry::class, 'se', Join::WITH, 's.id = se.setlist')
            ->innerJoin(Intermission::class, 'i', Join::WITH, 'i.id = se.intermission')
            ->andWhere('s.id = :setlistId')
            ->select('sum(i.duration)')
            ->setParameter('setlistId', $setlist->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $speechesDuration = $this->createQueryBuilder('s')
            ->innerJoin(SetlistEntry::class, 'se', Join::WITH, 's.id = se.setlist')
            ->innerJoin(Speech::class, 'sp', Join::WITH, 'sp.id = se.speech')
            ->andWhere('s.id = :setlistId')
            ->select('sum(sp.duration)')
            ->setParameter('setlistId', $setlist->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $coversDuration + $blocksDuration + $intermissionsDuration + $speechesDuration;
    }

    /**
     * Retourne le nombre d'éléments structurant une setlist.
     *
     * @return int Le nombre d'éléments
     */
    public function findElementsCountInAGivenSetlist(Setlist $setlist)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin(SetlistEntry::class, 'se', Join::WITH, 's.id = se.setlist')
            ->andWhere('s.id = :setlistId')
            ->select('count(se.id)')
            ->setParameter('setlistId', $setlist->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Retourne la durée totale d'une setlist (avec majoration du fait des transitions entre les éléments structurants de la setlist).
     *
     * @return int Durée en secondes
     */
    public function getTotalDurationWithTransitionOfAGivenSetlist(Setlist $setlist)
    {
        $setlistElements = $this->findElementsCountInAGivenSetlist($setlist);

        if (0 === $setlistElements) { // si la setlist ne contient aucun élément, sa durée est nulle
            return 0;
        }
        $setlistDuration = $this->getDurationWithoutTransitionOfAGivenSetlist($setlist);

        return $setlistDuration + 30 * ($setlistElements - 1);
    }

    /**
     * Retourne le nombre de covers d'une setlist.
     *
     * @return int Le nombre de covers
     */
    public function getCoversCountInAGivenSetlist(Setlist $setlist)
    {
        $coversSoloCount = $this->createQueryBuilder('s')
            ->innerJoin(SetlistEntry::class, 'se', Join::WITH, 's.id = se.setlist')
            ->innerJoin(Cover::class, 'c', Join::WITH, 'c.id = se.cover')
            ->andWhere('s.id = :setlistId')
            ->select('count(c.id)')
            ->setParameter('setlistId', $setlist->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $coversInBlocksCount = $this->createQueryBuilder('s')
            ->innerJoin(SetlistEntry::class, 'se', Join::WITH, 's.id = se.setlist')
            ->innerJoin(Block::class, 'b', Join::WITH, 'b.id = se.block')
            ->innerJoin(BlockHasCovers::class, 'bhc', Join::WITH, 'b.id = bhc.block')
            ->innerJoin(Cover::class, 'c', Join::WITH, 'c.id = bhc.cover')
            ->andWhere('s.id = :setlistId')
            ->select('count(c.id)')
            ->setParameter('setlistId', $setlist->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $coversSoloCount + $coversInBlocksCount;
    }

    /**
     * Retourne le nombre de pauses dans une setlist.
     *
     * @return int Le nombre de pauses
     */
    public function getIntermissionsCountInAGivenSetlist(Setlist $setlist)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin(SetlistEntry::class, 'se', Join::WITH, 's.id = se.setlist')
            ->innerJoin(Intermission::class, 'i', Join::WITH, 'i.id = se.intermission')
            ->andWhere('s.id = :setlistId')
            ->select('count(i.id)')
            ->setParameter('setlistId', $setlist->getId())
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
