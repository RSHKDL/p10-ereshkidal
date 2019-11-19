<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

/**
 * Class BaseFixture
 * @author ereshkidal
 */
abstract class BaseFixture extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var Generator
     */
    protected $faker;

    abstract protected function loadData(ObjectManager $manager): void;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    protected function createMany(string $className, int $count, callable $factory): void
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i, $this->faker);
            $this->manager->persist($entity);
            // store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className . '_' . $i, $entity);
        }
    }
}
