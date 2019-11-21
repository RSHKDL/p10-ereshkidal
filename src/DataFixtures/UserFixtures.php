<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UserFixtures
 * @author ereshkidal
 */
class UserFixtures extends BaseFixture
{
    private static $authorNames = [
        'Ereshkidal',
        'Sinndrae',
        'Folkstorm',
        'NeeeKo',
        'Azo',
        'Rango',
        'Mimi'
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(7, 'main_users', static function (int $i) {
            $user = new User();
            $user->setEmail(sprintf('%s@example.com', strtolower(self::$authorNames[$i])));
            $user->setUsername(self::$authorNames[$i]);

            return $user;
        });
        $manager->flush();
    }
}
