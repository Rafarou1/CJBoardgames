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
        yield ["Inis", "strategy", 3, 1998, 1];
        yield ["Shadow Hunters", "social", 2, 2010, 1];
        yield ["Flamme rouge", "strategy", 2, 2016, 2];
        
    }

    private static function reserveDataGenerator()
    {
        yield ["CJ", "La réserve de jeu du CJ"];
        yield ["Orteaux", "C'est la famille"];
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::reserveDataGenerator() as [$name, $description] ) {
            $reserve = new Reserve();
            $reserve->setName($name);
            $reserve->setDescription($description);
            // $reserve->setId($id);
            $manager->persist($reserve);          
        }
        $manager->flush();
    
        $reserveRepo = $manager->getRepository(Reserve::class);

        // $boardgameRepo = $manager->getRepository(Boardgame::class);

        foreach (self::boardgameDataGenerator() as [$name, $type, $difficulty, $year, $reserve_id] ) {
            $boardgame = new Boardgame();
            $boardgame->setName($name);
            $boardgame->setType($type);
            $boardgame->setDifficulty($difficulty);
            $boardgame->setYear($year);
            $reserve = $reserveRepo->find($reserve_id);
            $boardgame->setReserve($reserve);
            $manager->persist($boardgame);          
        }
        $manager->flush();

    }
}