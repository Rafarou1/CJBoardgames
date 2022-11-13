<?php

namespace App\DataFixtures;

use App\Entity\Boardgame;
use App\Entity\Reserve;
use App\Repository\BoardgameRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    /**
     * Generates initialization data for boardgames : [name, year]
     * @return \\Generator
     */
    private static function boardgameDataGenerator()
    {
        yield ["Inis", "strategy", 3, 1998];
        yield ["Shadow Hunters", "social", 2, 2010];
        
    }

    private static function reserveDataGenerator()
    {
        yield ["Orteaux", "C'est la famille"];
        yield ["CJ", "La réserve de jeu du CJ"];
    }

    public function load(ObjectManager $manager)
    {

        $reserveRepo = $manager->getRepository(Reserve::class);

        foreach (self::reserveDataGenerator() as [$name, $description] ) {
            $reserve = new Reserve();
            $reserve->setName($name);
            $reserve->setDescription($description);
            $manager->persist($reserve);          
        }
    

        $boardgameRepo = $manager->getRepository(Boardgame::class);

        foreach (self::boardgameDataGenerator() as [$name, $type, $difficulty, $year] ) {
            $boardgame = new Boardgame();
            $boardgame->setName($name);
            $boardgame->setType($type);
            $boardgame->setDifficulty($difficulty);
            $boardgame->setYear($year);
            $boardgame->setReserve($reserve);
            $manager->persist($boardgame);          
        }
        $manager->flush();

    }
}