<?php

namespace App\DataFixtures;

use App\Entity\Tuning;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TuningFixtures extends Fixture
{
    public const TUNING_NORMAL_REFERENCE = 'tuning-normal';
    public const TUNING_DROP_B_REFERENCE = 'tuning-drop-b';
    public const TUNING_DROP_D_REFERENCE = 'tuning-drop-d';

    public function load(ObjectManager $manager)
    {
        $tuningDatas = [
            '0' => [
                'description' => 'drop B',
            ],
            '1' => [
                'description' => 'drop D',
            ],
            '2' => [
                'description' => 'standard',
            ],
        ];

        foreach ($tuningDatas as $tuningData) {
            $tuning = new Tuning();
            $tuning->setDescription($tuningData['description']);

            switch ($tuningData['description']) {
                case 'drop B':
                    $this->addReference(self::TUNING_DROP_B_REFERENCE, $tuning);
                    break;
                case 'drop D':
                    $this->addReference(self::TUNING_DROP_D_REFERENCE, $tuning);
                    break;
                case 'standard':
                    $this->addReference(self::TUNING_NORMAL_REFERENCE, $tuning);
                    break;
                default:
                    break;
            }

            $manager->persist($tuning);
        }

        $manager->flush();
    }
}
