<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct()
    {

    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $names = [
            [
                'name' => 'Metahan Kenan Akdemir',
                'mobilePhone' => '05301234567',
                'email' => 'metehan@gmail.com'

            ],
            [
                'name' => 'Gönül Akdemir',
                'mobilePhone' => '05307654321',
                'email' => 'gonul@gmail.com'

            ],
            [
                'name' => 'Rafet Akdemir',
                'mobilePhone' => '05305554433',
                'email' => 'rafet@gmail.com'

            ],
            [
                'name' => 'Can Akdemir',
                'mobilePhone' => '05302223344',
                'email' => 'can@gmail.com'

            ],
            [
                'name' => 'Caner Akdemir',
                'mobilePhone' => '05306667799',
                'email' => 'caner@gmail.com'

            ],
            [
                'name' => 'Zeynep Akdemir',
                'mobilePhone' => '05307776633',
                'email' => 'zeynep@gmail.com'

            ],
            [
                'name' => 'Şirin Akdemir',
                'mobilePhone' => '05303452211',
                'email' => 'sirin@gmail.com'

            ],
            [
                'name' => 'Melek Duru Akdemir',
                'mobilePhone' => '05301232244',
                'email' => 'melek.duru@gmail.com'

            ],
            [
                'name' => 'Ali Eymen Akdemir',
                'mobilePhone' => '05301232244',
                'email' => 'ali.eymen@gmail.com'

            ],
            [
                'name' => 'Mustafa Akdemir',
                'mobilePhone' => '05305566756',
                'email' => 'mustafa@gmail.com'

            ]
        ];

        foreach ($names as $i => $iValue) {
            $reservation = new Reservation();
            $reservation->setName($iValue['name']);
            $reservation->setMobilePhone($iValue['mobilePhone']);
            $reservation->setEmail($iValue['email']);
            $reservation->setCreatedAt(new \DateTime('now'));
            $reservation->setDescription('Açıklama - ' . $i);
            $reservation->setReservationDate(new \DateTime('now'));
            $manager->persist($reservation);
            $manager->flush();
        }


    }

    public static function getGroups(): array
    {
        return ['reservation'];
    }
}
