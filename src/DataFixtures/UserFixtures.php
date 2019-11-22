<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(7, 'main_users', function (int $i) {
            $user = new User();
            $user->setEmail(sprintf('%s@example.com', strtolower(self::$authorNames[$i])));
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, 'engage'));
            $user->setUsername(self::$authorNames[$i]);

            return $user;
        });
        $manager->flush();
    }
}
