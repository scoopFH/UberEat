<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use App\Entity\Order;
use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use PhpParser\Node\Stmt\Foreach_;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $restaurants = [];

        $bdd = json_decode('{"restaurants":[
            {"name":"Bagels Coffee",
            "picture":"https://www.discoverbenelux.com/wp-content/uploads/2019/07/MG_6733-mozzarella-bagel-1.jpg",
            "promotion":"https://www.brueggers.com/wp-content/uploads/2019/08/19-131-MW8.29-Fall-Promotion-Web-Slider-Images-1024x568-Coffee1.jpg",
            "dishes":[
              {"name":"le Bronx","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC9lOTczMDdjNC1iMGFhLTRkMTktYTM4NC1mMjViOGU1ZTFlZTEuanBlZw=="},
            {"name":"le Brooklyn","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC9mMzJiODJhMy0zZDI5LTQzZDktODdlMC1iZDQ2ZTNmNGIxMTMuanBlZw=="},
            {"name":"le New Jersey","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC8wYmRiYTA2Yy0wYjQ3LTRhMjQtYjdiNC05MWE5ODkwNmZkYjYuanBlZw=="},
            {"name":"le Soho","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC80NmU0OGY2My03ZGZhLTQ3MzEtOTBiZS01YWMyNDA2ODFkNzguanBlZw=="},
            {"name":"Hot dog le New York","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC9iNDYzMzA5NC00NTFlLTQwOWEtYjZhNS1lNTk2NmFmNWM3MzcuanBlZw=="}
            ]
            },

            {"name":"NACHOS",
            "picture":"https://assets.afcdn.com/recipe/20180406/78384_w1024h1024c1cx2808cy1872.jpg",
            "promotion":"",
            "dishes":[
              {"name": "Bowl - Poulet Paprika","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC9jM2M0YWVhYS0yMDY1LTRjYjYtOTk3Yi1iMjFmMTBkYmU5ODguanBlZw=="},
            {"name":"Bowl - Boeuf Chili","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC9kNGMwZTEyYy02MDg2LTQ1OTctYTMzZC01MzI0YmIxYTkwOTIuanBlZw=="},
            {"name":"Bowl - Porc Barbacoa","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC8zNjY1ODY3OS1kOTM0LTQzOWYtOGI2MC1iY2E0OGQ4OTFlM2UuanBlZw=="},
            {"name":"Quesadillas","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC80NDIwZjJlOS1mZjVhLTRmM2MtOGMxNi01M2Q2NjMxMDkxYzIuanBlZw=="},
            {"name":"Nachos à partager","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC9hNjIwMmRhZS05YmZjLTRmNzItODJlMi05MTk0YmJiYjNmOTcuanBlZw=="}
            ]
        },
                {
            "name":"Subway",
            "picture":"https://www.neorestauration.com/mediatheque/6/6/5/000024566_600x400_c.png",
            "promotion":"https://i.pinimg.com/originals/0d/bd/71/0dbd71823d92667df9555eeab53e28bd.jpg",
            "dishes":[{"name":"Röstis","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC84MGU2NzNjMy05YTE3LTRjNzItYTEzYi05N2VlMDU0OTQxMDIuanBlZw=="},
            {"name":"Crousti Chicken","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC82NzkxYmJkNy02NjI5LTQ4NmUtYTU2OS01NGE2ZWYwMzE0ZTAuanBlZw=="},
            {"name":"Wrap Veggie Quinoa","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC8xMTVkYTU1MC00YTZjLTQ5ZDItYmY2ZS01MzQ0NjU4OTEyNTQuanBlZw=="},
            {"name":"Wrap Bœuf guacamole","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC85NzA3NzBmMy0xYTQzLTQ0ZjktODdhMC1mNDJhMzg5MDAwYjcuanBlZw=="},
            {"name":"SUB30 Raclette","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC8wMzJjNWNkMC0wODljLTRkNDMtYTllOS00M2RhMjUxOWRjNGUuanBlZw=="}
            ]
        },
        
        {
            "name":"KFC",
            "picture":"https://d1ralsognjng37.cloudfront.net/cd330c83-b9f5-4a2a-ac45-ca55cb0ec77e.jpeg",
            "promotion":"https://i.ytimg.com/vi/X1qErbDH93w/maxresdefault.jpg",
            "dishes":[{"name": "Crousti Fromage Raclette","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC83NWUwMGZmYy01MDA0LTQ0MjAtYTEwMy04NDEyMjBkOTQ1ZjEuanBlZw=="},
            {"name":"The Original Wrapper","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC8zNzc2MzAwYy0yYjllLTRiZTYtOTg5NC04MDFlMzZlM2NjODEuanBlZw=="},
            {"name":"Tower Raclette","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC9iYWMwYjE4Yy01ZWE5LTQ0NmEtYmYzZS05MmMyOTBkOTk3NGMuanBlZw=="},
            {"name":"Double Stacker Cheese & Bacon","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC81YmQ4NDdhMC1hMTM4LTQxNzktYWUxYS1jNmM4ODk5YzY1ZmIuanBlZw=="},
            {"name":"Boxmaster","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC8yZWZlYzUzZi00YWYwLTRiOWQtOWVhNS03YjAyNDQ5Mzg1YzcuanBlZw=="}
            ]
        }
        ]
}');

        if (is_array($bdd) || is_object($bdd)) {
            foreach ($bdd->restaurants as &$restaurantBdd) {
                $restaurant = new Restaurant();
                foreach ($restaurantBdd->dishes as &$dishBdd) {
                    $dish = new Dish();
                    $dish
                        ->setName($dishBdd->name)
                        ->setprice($faker->numberBetween(1, 16))
                        ->setpreview($dishBdd->preview);
                    $manager->persist($dish);
                    $restaurant->addDish($dish);
                }

                $restaurant
                    ->setName($restaurantBdd->name)
                    ->setPicture($restaurantBdd->picture)
                    ->setAddress($faker->streetAddress())
                    ->setCity($faker->city())
                    ->setPromotion($restaurantBdd->promotion);

                $manager->persist($restaurant);
                $restaurants[] = $restaurant;
            }
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

        $user = new User();
        $user->setEmail('daniel@gmail.com')
            ->setLastname('Daniel')
            ->setFirstname('Faucheron')
            ->setaddress('12 rue de Jeaubourg')
            ->setCity('Lyon')
            ->setBalance(1200)
            ->setPassword('password');
        $manager->persist($user);

        $manager->flush();
    }
}
