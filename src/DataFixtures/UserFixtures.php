<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const PLAIN_PASSWORD = 'Abcdef@123456';
    public const USER_USER = 'user-user';
    public const USER_ADMIN_REFERENCE = 'user-admin';
    public const USER_ASSOCIATION_BUREAU_MEMBER_REFERENCE = 'user-association-bureau-member';
    
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // user
        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            self::PLAIN_PASSWORD,
        );

        $user->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setNickname($user->getFirstname())
            ->setEmail($faker->email())
            ->setPassword($hashedPassword)
            ->setRoles(['ROLE_USER']);

        $manager->persist($user);

        $this->addReference(self::USER_USER, $user);

        // association bureau member
        $user = new User();
        $user->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setNickname($user->getFirstname())
            ->setEmail($faker->email())
            ->setPassword($hashedPassword)
            ->setRoles(['ROLE_ASSOCIATION_BUREAU_MEMBER']);

        $manager->persist($user);

        $this->addReference(self::USER_ASSOCIATION_BUREAU_MEMBER_REFERENCE, $user);

        // admin
        $user = new User();
        $user->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setNickname($user->getFirstname())
            ->setEmail($faker->email())
            ->setPassword($hashedPassword)
            ->setRoles(['ROLE_ADMIN']);
        
        $manager->persist($user);

        $this->addReference(self::USER_ADMIN_REFERENCE, $user);

        $manager->flush();
    }

    // public function getDependencies()
    // {
    //     return [
    //         RoleFixtures::class,
    //         StructureFixtures::class,
    //     ];
    // }
}
