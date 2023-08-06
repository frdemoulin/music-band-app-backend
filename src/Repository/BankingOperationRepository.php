<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\BankingOperation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method BankingOperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankingOperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankingOperation[]    findAll()
 * @method BankingOperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankingOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankingOperation::class);
    }

    /**
     * Retourne les opérations bancaires sans facture hors frais kilométriques.
     *
     * @return BankingOperation[] Returns an array of BankingOperation objects
     */
    public function findBankingOperationsWithoutInvoiceExcludingMileageCharges()
    {
        return $this->createQueryBuilder('bo')
            ->andWhere('bo.invoice is NULL')
            ->andWhere('bo.object NOT LIKE :kmShort')
            ->andWhere('bo.object NOT LIKE :kmLong')
            ->setParameter('kmShort', '%km%')
            ->setParameter('kmLong', '%kilom%')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne les opérations bancaires correspondant aux frais kilométriques pour une année et un utilisateur (optionnel) donnés
     * @return BankingOperation[] Returns an array of BankingOperation objects
    */
    public function findMileageExpendituresForAGivenYearAndAGivenOptionalUser(int $year, User $user = null)
    {
        return $this->createQueryBuilder('bo')
            ->join('bo.fiscal_year', 'fy')
            ->join('bo.business_contact', 'bc')
            ->join('bo.banking_operation_sort', 'bos')
            ->andWhere('fy.year = :year')
            ->andWhere('bos.type = "dépense"')
            ->andWhere('bc.corporation_name = :associationCorporationName')
            ->andWhere('bc.contact_firstname LIKE :userFirstname')
            ->andWhere('bc.contact_lastname LIKE :userLastname')
            ->setParameter('year', $year)
            ->setParameter('associationCorporationName', 'Citizens of Muse')
            ->setParameter('userFirstname', '%' . $user->getFirstname() .'%')
            ->setParameter('userLastname', '%' . $user->getLastname() .'%')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne le montant total des indemnités kilométriques versées à la date du jour pour une année donnée
     * @return int|null
     */
    public function findTotalMileageExpendituresForAGivenYearTillTheCurrentDay(int $year): ?int
    {
        return $this->createQueryBuilder('bo')
            ->select('SUM(bo.amount) / 100')
            ->join('bo.fiscal_year', 'fy')
            ->join('bo.business_contact', 'bc')
            ->join('bo.banking_operation_sort', 'bos')
            ->andWhere('bo.date <= CURRENT_TIMESTAMP()')
            ->andWhere('fy.year = :year')
            ->andWhere('bos.type = :bosTypeString')
            ->andWhere('bc.corporation_name = :associationCorporationName')
            ->andWhere('bo.object LIKE :objectString')
            ->setParameter('objectString', '%Frais km%')
            ->setParameter('bosTypeString', 'dépense')
            ->setParameter('year', $year)
            ->setParameter('associationCorporationName', 'Citizens of Muse')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Retourne le montant total des indemnités kilométriques versées à la date du jour pour un utilisateur et une année donnés
     * @return float|null
     */
    // TOOD: à vérifier
    public function findTotalMileageExpendituresForAGivenYearTillTheCurrentDayAndAGivenUser(int $year, User $user): ?float
    {
        return $this->createQueryBuilder('bo')
            ->select('SUM(bo.amount) / 100')
            ->join('bo.fiscal_year', 'fy')
            ->join('bo.banking_operation_sort', 'bos')
            ->join('bo.business_contact', 'bc')
            ->andWhere('bo.date <= CURRENT_DATE()')
            ->andWhere('fy.year = :year')
            ->setParameter('year', $year)
            ->andWhere('bos.id = 1')
            ->andWhere('LOWER(bo.object) LIKE :mileageAllowanceString')
            ->setParameter('mileageAllowanceString', '%frais km%')
            ->andWhere('bc.is_supplier = 1')
            ->andWhere('bc.corporation_name LIKE :associationCorporationName')
            ->setParameter('associationCorporationName', '%Citizens of Muse%')
            ->andWhere('bc.contact_firstname LIKE :contactFirstname')
            ->setParameter('contactFirstname', '%'.$user->getFirstname().'%')
            ->andWhere('bc.contact_lastname LIKE :contactLastname')
            ->setParameter('contactLastname', '%'.$user->getLastname().'%')
            ->andWhere('bc.corporation_name LIKE :associationCorporationName')
            ->setParameter('associationCorporationName', '%Citizens of Muse%')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Retourne les années fiscales pour lesquelles des opérations bancaires ont été renseignées
     * @return array|null
    */
    public function getBankingOperationYears(): ?array
    {
        return $this->createQueryBuilder('bo')
            ->select('fy.year')
            ->join('bo.fiscal_year', 'fy')
            ->groupBy('fy.year')
            ->orderBy('fy.year', 'ASC')
            ->getQuery()
            ->getSingleColumnResult()
        ;
    }

    /**
     * Retourne le nombre total d'encaissements pour une année fiscale (optionnelle) donnée
     * @param ?int $fiscalYear
     * @return int|null
    */
    public function countTotalRevenues(int $fiscalYear = null): ?int
    {
        $qb = $this->createQueryBuilder('bo')
        ->select('COUNT(bo.id)')
        ->join('bo.fiscal_year', 'fy')
        ->join('bo.banking_operation_sort', 'bos')
        ->join('bo.business_contact', 'bc');

        if (isset($fiscalYear)) {
            $qb
                ->andWhere('fy.year = :year')
                ->setParameter('year', $fiscalYear);
        }

        return $qb
            ->andWhere('bos.type LIKE :bosTypeString')
            ->setParameter('bosTypeString', 'recette')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Retourne le nombre total de dépenses pour une année fiscale (optionnelle) donnée
     * @param ?int $fiscalYear
     * @return int|null
    */
    public function countTotalExpenditures(int $fiscalYear = null): ?int
    {
        $qb = $this->createQueryBuilder('bo')
        ->select('COUNT(bo.id)')
        ->join('bo.fiscal_year', 'fy')
        ->join('bo.banking_operation_sort', 'bos')
        ->join('bo.business_contact', 'bc');

        if (isset($fiscalYear)) {
            $qb
                ->andWhere('fy.year = :year')
                ->setParameter('year', $fiscalYear);
        }

        return $qb
            ->andWhere('bos.type LIKE :bosTypeString')
            ->setParameter('bosTypeString', 'dépense')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Retourne le montant total des encaissements pour une année fiscale (optionnelle) donnée
     * @param ?int $fiscalYear
     * @return int|null
    */
    public function getTotalRevenuesAmount(int $fiscalYear = null): ?int
    {
        $qb = $this->createQueryBuilder('bo')
        ->select('SUM(bo.amount)')
        ->join('bo.fiscal_year', 'fy')
        ->join('bo.banking_operation_sort', 'bos')
        ->join('bo.business_contact', 'bc');

        if (isset($fiscalYear)) {
            $qb
                ->andWhere('fy.year = :year')
                ->setParameter('year', $fiscalYear);
        }

        return $qb
            ->andWhere('bos.type LIKE :bosTypeString')
            ->setParameter('bosTypeString', 'recette')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Retourne le montant total des dépenses pour une année fiscale (optionnelle) donnée
     * @param ?int $fiscalYear
     * @return int|null
    */
    public function getTotalExpendituresAmount(int $fiscalYear = null): ?int
    {
        $qb = $this->createQueryBuilder('bo')
        ->select('SUM(bo.amount)')
        ->join('bo.fiscal_year', 'fy')
        ->join('bo.banking_operation_sort', 'bos')
        ->join('bo.business_contact', 'bc');

        if (isset($fiscalYear)) {
            $qb
                ->andWhere('fy.year = :year')
                ->setParameter('year', $fiscalYear);
        }

        return $qb
            ->andWhere('bos.type LIKE :bosTypeString')
            ->setParameter('bosTypeString', 'dépense')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
