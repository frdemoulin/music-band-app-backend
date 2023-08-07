<?php

namespace App\Repository;

use App\Entity\BackingTrack;
use App\Entity\BackingTrackSort;
use App\Entity\Cover;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cover|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cover|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cover[]    findAll()
 * @method Cover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cover::class);
    }

    /**
     * @return Cover[] Returns an array of Cover objects
     */
    public function findAllCoversWithTotalDuration()
    {
        $covers = $this->createQueryBuilder('c')
            ->join('c.song', 's')
            ->orderBy('s.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        foreach ($covers as $value) {
            if (null !== $value->getIntro()) { // si le cover a une intro
                $introDurationSeconds = $value->getIntro()->getDuration();
            } else {
                $introDuration = new \DateTime('@0');
                $introDurationSeconds = (int) $introDuration->format('U');
            }

            if (null !== $value->getOutro()) { // si le cover a une outro
                $outroDurationSeconds = $value->getOutro()->getDuration();
            } else {
                $outroDuration = new \DateTime('@0');
                $outroDurationSeconds = (int) $outroDuration->format('U');
            }

            $songDurationSeconds = $value->getSong()->getDuration();

            $coverDurationSeconds = $introDurationSeconds + $songDurationSeconds + $outroDurationSeconds;

            $coverDuration = gmdate('H:i:s', $coverDurationSeconds);

            // $value->setDuration(new DateTime($coverDuration));
        }

        return $covers;
    }

    /**
     *  Retourne les types de BT déjà uploadés pour un cover donné.
     *
     * @param Cover $cover Le cover
     *
     * @return BackingTrackSort[] Returns an array of BackingTrackSort names for a given cover
     */
    public function getBackingTrackSortNamesAlreadyUploadedForAGivenCover(Cover $cover)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin(BackingTrack::class, 'bt', Join::WITH, 'c.id = bt.cover')
            ->innerJoin(BackingTrackSort::class, 'bts', Join::WITH, 'bts.id = bt.backingTrackSort')
            ->select('bts.name', 'bt.updatedAt')
            ->andWhere('c.id = :coverId')
            ->setParameter('coverId', $cover->getId())
            ->orderBy('bts.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return string Retourne le nombre total de covers
     */
    public function getCoversCount()
    {
        $count = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $count;
    }

    /**
     * @return string Retourne le nombre total de chansons distinctes engagées dans l'ensemble des covers
     */
    public function getDistinctSongsInCoversCount()
    {
        $count = $this->createQueryBuilder('c')
            ->groupBy('c.song')
            ->select('COUNT(c.song)')
            ->getQuery()
            ->getScalarResult()
        ;

        return \count($count);
    }

    // /**
    //  * @return Cover[] Returns an array of Cover objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cover
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
