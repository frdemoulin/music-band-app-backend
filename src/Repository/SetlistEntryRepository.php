<?php

namespace App\Repository;

use App\Entity\Setlist;
use App\Entity\SetlistEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SetlistEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method SetlistEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method SetlistEntry[]    findAll()
 * @method SetlistEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SetlistEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SetlistEntry::class);
    }

    /**
     * Retourne le plus grand rankInSetlist trouvé en base pour la setlist courante.
     *
     * @return int
     */
    public function getHighestRankInSetlist(Setlist $setlist)
    {
        return $this->createQueryBuilder('se')
            ->andWhere('se.setlist = :setlist')
            ->setParameter('setlist', $setlist)
            ->select('MAX(se.rankInSetlist)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
