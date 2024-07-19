<?php

namespace App\DataFixtures;

use App\Entity\Candy;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CandyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));

        for ($i = 0; $i < 100; $i++) {
            $candy = new Candy();
            $candy->setName($faker->vehicleBrand());
            $candy->setDescription('toto');
            $candy->setCreateAt(new DateTimeImmutable());
            $candy->setSlug('toto');

            $manager->persist($candy);
        }

        $manager->flush();
    }
}
