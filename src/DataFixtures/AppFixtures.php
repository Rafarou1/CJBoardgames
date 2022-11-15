<?php

namespace App\DataFixtures;

use App\Entity\Boardgame;
use App\Entity\Reserve;
use App\Entity\Player;
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

    private static function playerDataGenerator()
    {
        yield ["Rafaël", "Respo jeu de société du CJ", 1];
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::reserveDataGenerator() as [$name, $description] ) {
            $reserve = new Reserve();
            $reserve->setName($name);
            $reserve->setDescription($description);
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

        foreach (self::playerDataGenerator() as [$name, $description, $reserve_id] ) {
            $player = new Player();
            $player->setName($name);
            $player->setDescription($description);
            $reserve = $reserveRepo->find($reserve_id);
            $player->setReserve($reserve);
            $manager->persist($player);          
        }
        $manager->flush();

    }
}