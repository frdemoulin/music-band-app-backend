<?php

namespace App\DataFixtures;

use App\Entity\Song;
use App\DataFixtures\AlbumFixtures;
use App\DataFixtures\TuningFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SongFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 19; $i++) {
            $song = new Song();

            $song->setTitle($faker->realText(25, 3))
                ->setDuration($faker->numberBetween(100, 600));

            switch ($i % 3) {
                case 0:
                    $song->setAlbum($this->getReference(AlbumFixtures::ALBUM_EP_REFERENCE));
                    $song->setTuning($this->getReference(TuningFixtures::TUNING_DROP_B_REFERENCE));
                    break;
                case 1:
                    $song->setAlbum($this->getReference(AlbumFixtures::ALBUM_LIVE_REFERENCE));
                    $song->setTuning($this->getReference(TuningFixtures::TUNING_DROP_D_REFERENCE));
                    break;
                case 2:
                    $song->setAlbum($this->getReference(AlbumFixtures::ALBUM_STUDIO_REFERENCE));
                    $song->setTuning($this->getReference(TuningFixtures::TUNING_NORMAL_REFERENCE));
                    break;
                default:
                    break;
            }
            $manager->persist($song);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AlbumFixtures::class,
            TuningFixtures::class,
        ];
    }
}
