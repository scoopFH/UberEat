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
        },
        {
            "name":"L\'Art en Burger",
            "picture":"https://d1ralsognjng37.cloudfront.net/2d7f9781-2d02-4602-82e1-d9d4d3d6938b.jpeg",
            "promotion":"",
            "dishes":[{"name": "Barry","preview":"https://d1ralsognjng37.cloudfront.net/5b6847ad-5c3f-46f0-bfd7-234fc1ed211c.jpeg"},
            {"name":"Le Jean Claude Dusse","preview":"https://d1ralsognjng37.cloudfront.net/243239c6-b7f7-4efd-b480-5532951ac883.jpeg"},
            {"name":"Seguin","preview":"https://d1ralsognjng37.cloudfront.net/81d4a0af-669d-4537-a6a2-ee96710bedce.jpeg"},
            {"name":"Charlie","preview":"https://d1ralsognjng37.cloudfront.net/70b8c733-d7b0-4ca2-8061-995c4bef8348.jpeg"},
            {"name":"Louis","preview":"https://d1ralsognjng37.cloudfront.net/ab045242-68b7-4d7c-b15f-811c07a7d714.jpeg"}
            ]
        },
        {
            "name":"YAAFA Falafel",
            "picture":"https://media-cdn.tripadvisor.com/media/photo-s/09/3e/af/54/yaafa.jpg",
            "promotion":"",
            "dishes":[{"name": "Falafels Box","preview":"https://d1ralsognjng37.cloudfront.net/5fb7724b-b624-4950-bb08-f52a9fbfb5c3.jpeg"},
            {"name":"Y\'a grosse faim","preview":"https://cn-geo1.uber.com/image-proc/resize/eats/format=webp/width=550/height=440/quality=70/srcb64=aHR0cHM6Ly9kMXJhbHNvZ25qbmczNy5jbG91ZGZyb250Lm5ldC84YTkwY2NkZC00MTRhLTQ5YmItYjk1MC1iZjdiMTViNTI0OTIuanBlZw=="},
            {"name":"Grec - pita","preview":"https://d1ralsognjng37.cloudfront.net/0e4c5286-f0c2-4d44-a801-dbd78c8c813e.jpeg"},
            {"name":"SOUPE DE BUTTER NUT","preview":"https://d1ralsognjng37.cloudfront.net/fb1310db-fe7e-42d5-b416-9cb381aec6e1.jpeg"},
            {"name":"Beat\'rave - pita","preview":"https://d1ralsognjng37.cloudfront.net/7d39e654-a5b0-4a3e-9919-520b65f4b536.jpeg"}
            ]
        },
        {
            "name":"Pazzi Di Pizza - Carla",
            "picture":"https://d1ralsognjng37.cloudfront.net/cbb6dc66-c0d4-47c3-8499-6441a14f6d97.jpeg",
            "promotion":"",
            "dishes":[{"name": "Pizza Reine","preview":"https://d1ralsognjng37.cloudfront.net/4dfa04e6-ce8d-49d6-885a-2a7069d614b7.jpeg"},
            {"name":"Pizza Indienne","preview":"https://d1ralsognjng37.cloudfront.net/2f53e593-b0f5-417b-8452-52775aa9250f.jpeg"},
            {"name":"Pizza Reine","preview":"https://d1ralsognjng37.cloudfront.net/4dfa04e6-ce8d-49d6-885a-2a7069d614b7.jpeg"},
            {"name":"Pizza Chèvre Miel - Tomate","preview":"https://d1ralsognjng37.cloudfront.net/85ed61c7-6ff5-4115-b0d0-a528a1dd0081.jpeg"},
            {"name":"Pizza Savoyarde","preview":"https://d1ralsognjng37.cloudfront.net/563b4118-f7a6-40ae-bee1-48c0d34098c5.jpeg"}
            ]
        },
        {
            "name":"Ciao Ciao",
            "picture":"https://cellerier-hallesdelyon.com/wp-content/uploads/2017/09/ciao-ciao-cellerier.jpg",
            "promotion":"",
            "dishes":[{"name": "Speck","preview":"https://d1ralsognjng37.cloudfront.net/119b6c0d-2898-4bd2-889f-4df3f2a71037.jpeg"},
            {"name":"Mortadelle","preview":"https://d1ralsognjng37.cloudfront.net/597a7528-e81e-495b-b377-19d5982b580e.jpeg"},
            {"name":"Saucisson abruzzeses","preview":"https://d1ralsognjng37.cloudfront.net/02ad5857-d7f6-4c29-9ce6-3a3eeb3b0c87.jpeg"},
            {"name":"Jambon cru de Parme","preview":"https://d1ralsognjng37.cloudfront.net/d24632bf-33e2-450e-9854-a2e3cd143c28.jpeg"},
            {"name":"Jambon cru San Danielle Contessa","preview":"https://d1ralsognjng37.cloudfront.net/faede4e7-7679-4d55-9738-4eb4d7f3042b.jpeg"}
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
                    ->setCity($faker->city());
                
                if(!empty($restaurantBdd->promotion)) {
                    $restaurant->setPromotion($restaurantBdd->promotion);
                }

                $manager->persist($restaurant);
                $restaurants[] = $restaurant;
            }
        }

        $user = new User();
        $user->setEmail('william.klein@gmail.com')
            ->setLastname('William')
            ->setFirstname('Klein')
            ->setaddress($faker->streetAddress())
            ->setCity($faker->state())
            ->setBalance(30)
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('password');

        $manager->persist($user);

        $user = new User();
        $user->setEmail('matthiaschometon787@gmail.com')
            ->setLastname('Matthias')
            ->setFirstname('Chometon')
            ->setaddress($faker->streetAddress())
            ->setCity($faker->state())
            ->setBalance($faker->numberBetween(60,2450))
            ->setRoles(['ROLE_RESTORER'])
            ->setRestaurant($restaurants[$faker->numberBetween(0, count($restaurants) - 1)])
            ->setPassword('password');
        $manager->persist($user);

        $user = new User();
        $user->setEmail('stef.klein38@gmail.com')
            ->setLastname('Stef')
            ->setFirstname('Klein')
            ->setaddress($faker->streetAddress())
            ->setCity($faker->state())
            ->setBalance($faker->numberBetween(60,2450))
            ->setPassword('password');
        $manager->persist($user);

        $manager->flush();
    }
}
