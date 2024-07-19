<?php

namespace App\DataFixtures;

use App\Entity\Candy;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CandyFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        $faker->addProvider(new \Faker\Provider\FakeCar($faker));

        for ($i = 0; $i < 100; $i++) {
            $candy = new Candy();
            $candy->setName($faker->words(3, true));
            $candy->setDescription($faker->text());
            $candy->setCreateAt(new DateTimeImmutable());
            $candy->setSlug($this->slugger->slug($candy->getName()));

            $manager->persist($candy);
        }

        $manager->flush();
    }
}
