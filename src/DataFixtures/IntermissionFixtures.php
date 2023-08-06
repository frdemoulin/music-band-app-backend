<?php

namespace App\DataFixtures;

use App\Entity\Intermission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IntermissionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; ++$i) {
            $intermission = new Intermission();

            $intermission
                ->setDescription('pause')
                ->setDuration(600 + $i * 300);

            $manager->persist($intermission);
        }

        $manager->flush();
    }
}
