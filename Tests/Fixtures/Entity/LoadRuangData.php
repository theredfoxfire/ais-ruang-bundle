<?php

namespace Ais\RuangBundle\Tests\Fixtures\Entity;

use Ais\RuangBundle\Entity\Ruang;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadRuangData implements FixtureInterface
{
    static public $ruangs = array();

    public function load(ObjectManager $manager)
    {
        $ruang = new Ruang();
        $ruang->setTitle('title');
        $ruang->setBody('body');

        $manager->persist($ruang);
        $manager->flush();

        self::$ruangs[] = $ruang;
    }
}
