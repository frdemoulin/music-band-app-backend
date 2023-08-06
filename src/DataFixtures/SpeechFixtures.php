<?php

namespace App\DataFixtures;

use App\Entity\Speech;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SpeechFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=2; $i < 11 ; $i++) { 
            $speech = new Speech();
            
            $speech->setDuration($i * 15);

            $manager->persist($speech);
        }

        $manager->flush();
    }
}
