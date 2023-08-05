<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, User::class);
        $this->em = $em;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Retourne les utilisateurs ayant déclaré des trajets pour une année donnée.
     */
    public function getUsersHavingTripsForAGivenYear(string $year): array
    {
        $emConfig = $this->em->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

        $result = $this->createQueryBuilder('u')
            ->join('u.trips', 't')
            ->andWhere('Year(t.date) = :year')
            ->setParameter('year', $year)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return array_map('reset', $result);
    }
    
    /**
     * Retourne un utilisateur à partir de son email
     *
     * @param string $email
     * @return User
     */
    public function findOneByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    /**
     * Retourne les utilisateurs ayant un rôle donné
     *
     * @param string $role
     * @return User[] Returns an array of User objects
     */
    public function findByRole(string $role): ?array
    {
        return $this->createQueryBuilder('u')
            ->andWhere("JSON_CONTAINS(u.roles, :certificates) = 1")
            ->setParameter('certificates', $role)
            ->getQuery()
            ->getResult();
    }
}
