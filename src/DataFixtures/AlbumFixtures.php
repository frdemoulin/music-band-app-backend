<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\AlbumSort;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AlbumFixtures extends Fixture
{
    public const ALBUM_EP_REFERENCE = 'album-ep';
    public const ALBUM_LIVE_REFERENCE = 'album-live';
    public const ALBUM_STUDIO_REFERENCE = 'album-studio';

    public function load(ObjectManager $manager)
    {
        $albumDatas = [
            '0' => [
                'title' => 'Showbiz',
                'album_sort_name' => 'studio',
                'released_year' => '1999',
            ],
            '1' => [
                'title' => 'Hullabaloo',
                'album_sort_name' => 'live',
                'released_year' => '2001',
            ],
            '2' => [
                'title' => 'Muse EP',
                'album_sort_name' => 'EP',
                'released_year' => '1998',
            ]
        ];

        foreach ($albumDatas as $albumData) {
            $album = new Album();
            $albumSort = new AlbumSort();
            $albumSort->setName($albumData['album_sort_name']);
            $album->setAlbumSort($albumSort)
                ->setTitle($albumData['title'])
                ->setReleasedYear($albumData['released_year']);
            
            $manager->persist($albumSort);
            $manager->persist($album);

            switch ($albumSort->getName()) {
                case 'EP':
                    $this->addReference(self::ALBUM_EP_REFERENCE, $album);
                    break;
                case 'live':
                    $this->addReference(self::ALBUM_LIVE_REFERENCE, $album);
                    break;
                case 'studio':
                    $this->addReference(self::ALBUM_STUDIO_REFERENCE, $album);
                    break;
                default:
                    break;
            }
        }

        $manager->flush();
    }
}
