<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $restaurants = [];
        $dishes = [];

        $states = array('delivered', 'in delivering', 'in preparation');

        for ($i = 0; $i < 25; $i++) {
            $dish = new Dish();
            $dish
                ->setName($faker->sentence(2))
                ->setprice($faker->numberBetween(1, 16))
                ->setpreview($faker->imageUrl());
            $manager->persist($dish);
            $dishes[] = $dish;
        }

        for ($i = 0; $i < 20; $i++) {
            $restaurant = new Restaurant();
            $restaurant
                ->setName($faker->sentence(2))
                ->setPicture($faker->imageUrl())
                ->setAddress($faker->streetAddress())
                ->setCity($faker->city())
                ->setPromotion($faker->imageUrl())
                ->addDish($dishes[$faker->numberBetween(0, count($dishes) - 1)]);

            $manager->persist($restaurant);
            $restaurants[] = $restaurant;
        }

        $user = new User();
        $user->setEmail('matthias@gmail.com')
            ->setLastname('Chometon')
            ->setFirstname('Matthias')
            ->setaddress('521 rue de la Vilette')
            ->setCity('Lyon')
            ->setBalance(30)
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('password');

        $manager->persist($user);

        $user = new User();
        $user->setEmail('william@gmail.com')
            ->setLastname('William')
            ->setFirstname('William')
            ->setaddress('52 rue du Colémara')
            ->setCity('Lyon')
            ->setBalance(600)
            ->setRoles(['ROLE_RESTORER'])
            ->setRestaurant($restaurants[$faker->numberBetween(0, count($restaurants) - 1)])
            ->setPassword('password');
        $manager->persist($user);

        $order = new Order();
        $order->setRestaurant($restaurants[$faker->numberBetween(0, count($restaurants) - 1)])
            ->setUsers($user)
            ->setDeliveryDate($faker->dateTime())
            ->setState($states[$faker->numberBetween(0, count($states) - 1)])
            ->addDish($dishes[$faker->numberBetween(0, count($dishes) - 1)]);
        $manager->persist($order);

        $manager->flush();
    }
}
