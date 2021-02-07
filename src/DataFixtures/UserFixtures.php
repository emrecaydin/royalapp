<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public const USER = 'USER';
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {

        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        //  php bin/console doctrine:fixtures:load
        $userTypes = ['ROLE_CUSTOMER', 'ROLE_USER', 'ROLE_MANAGER', 'ROLE_ADMIN', 'ROLE_SUPERADMIN'];
        $userNames = [
            'TANER AKDEMİR'
        ];
        $userMails = [
            'taneryzb@hotmail.com'
        ];

        $userTitles = [
            'MÜZE MÜDÜRÜ'
        ];

        for ($i = 0, $iMax = count($userNames); $i < $iMax; $i++) {
            $name = $userNames[$i];
            $userName = $userMails[$i];
            $password = '123456';
            $user = new User();
            $user->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
            $user->setEmail($userName);
            $user->setTitle($userTitles[$i]);
            $user->setName(mb_strtoupper($name));
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));
            $user->setRoles([$userTypes[random_int(0, (count($userTypes) - 1))]]);
            $user->setMobilePhone('05303200647');
            $manager->persist($user);
            $manager->flush();
        }

    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
