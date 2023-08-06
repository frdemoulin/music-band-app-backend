<?php

namespace App\DataFixtures;

use App\Entity\SetlistEntrySort;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SetlistEntrySortFixtures extends Fixture
{
    public const SETLIST_ENTRY_BLOCK_SORT_REFERENCE = 'setlist-entry-block';
    public const SETLIST_ENTRY_COVER_SORT_REFERENCE = 'setlist-entry-cover';
    public const SETLIST_ENTRY_INTERMISSION_SORT_REFERENCE = 'setlist-entry-intermission';
    public const SETLIST_ENTRY_SPEECH_SORT_REFERENCE = 'setlist-entry-speech';

    public function load(ObjectManager $manager)
    {
        $setlistEntrySortDatas = [
            '0' => [
                'type' => 'block',
            ],
            '1' => [
                'type' => 'cover',
            ],
            '2' => [
                'type' => 'intermission',
            ],
            '3' => [
                'type' => 'speech',
            ],
        ];

        foreach ($setlistEntrySortDatas as $setlistEntrySortData) {
            $setlistEntrySort = new SetlistEntrySort();

            $setlistEntrySort->setType($setlistEntrySortData['type']);

            switch ($setlistEntrySortData['type']) {
                case 'block':
                    $this->addReference(self::SETLIST_ENTRY_BLOCK_SORT_REFERENCE, $setlistEntrySort);
                    break;
                case 'cover':
                    $this->addReference(self::SETLIST_ENTRY_COVER_SORT_REFERENCE, $setlistEntrySort);
                    break;
                case 'intermission':
                    $this->addReference(self::SETLIST_ENTRY_INTERMISSION_SORT_REFERENCE, $setlistEntrySort);
                    break;
                case 'speech':
                    $this->addReference(self::SETLIST_ENTRY_SPEECH_SORT_REFERENCE, $setlistEntrySort);
                    break;
                default:
                    break;
            }

            $manager->persist($setlistEntrySort);
        }

        $manager->flush();
    }
}
