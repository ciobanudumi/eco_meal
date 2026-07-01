<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Business;
use App\Entity\BusinessType;
use App\Entity\Category;
use App\Entity\Consumer;
use App\Entity\Order;
use App\Entity\Package;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // --- Business Types ---
        $restaurantType = new BusinessType();
        $restaurantType->setName('Restaurant');
        $manager->persist($restaurantType);

        $bakeryType = new BusinessType();
        $bakeryType->setName('Bakery');
        $manager->persist($bakeryType);

        // --- Categories ---
        $mealsCategory = new Category();
        $mealsCategory->setName('Meals');
        $manager->persist($mealsCategory);

        $bakedGoodsCategory = new Category();
        $bakedGoodsCategory->setName('Baked Goods');
        $manager->persist($bakedGoodsCategory);

        // --- Businesses ---
        $business1 = new Business();
        $business1->setName('Green Bistro');
        $business1->setCity('Craiova');
        $business1->setStreet('Calea Bucuresti');
        $business1->setHouseNumber('12A');
        $business1->setPhoneNumber('0740123456');
        $business1->setBusinessType($restaurantType);
        $manager->persist($business1);

        $business2 = new Business();
        $business2->setName('Sunrise Bakery');
        $business2->setCity('Craiova');
        $business2->setStreet('Str. Unirii');
        $business2->setHouseNumber('5');
        $business2->setPhoneNumber('0741987654');
        $business2->setBusinessType($bakeryType);
        $manager->persist($business2);

        // --- Consumers ---
        $consumer1 = new Consumer();
        $consumer1->setFirstName('Andrei');
        $consumer1->setLastName('Popescu');
        $consumer1->setPhoneNumber('0722111222');
        $manager->persist($consumer1);

        $consumer2 = new Consumer();
        $consumer2->setFirstName('Maria');
        $consumer2->setLastName('Ionescu');
        $consumer2->setPhoneNumber('0733444555');
        $manager->persist($consumer2);

        // --- Packages ---
        $package1 = new Package();
        $package1->setName('Surprise Lunch Box');
        $package1->setDescription('Leftover lunch dishes at a discounted price.');
        $package1->setPrice(19.99);
        $package1->setPhoto(null);
        $package1->setCreatedAt(new \DateTimeImmutable());
        $package1->setCategory($mealsCategory);
        $package1->setBusiness($business1);
        $manager->persist($package1);

        $package2 = new Package();
        $package2->setName('End of Day Pastries');
        $package2->setDescription('Assorted pastries from today\'s batch.');
        $package2->setPrice(12.50);
        $package2->setPhoto(null);
        $package2->setCreatedAt(new \DateTimeImmutable());
        $package2->setCategory($bakedGoodsCategory);
        $package2->setBusiness($business2);
        $manager->persist($package2);

        $package3 = new Package();
        $package3->setName('Chef\'s Mystery Box');
        $package3->setDescription('A mix of today\'s unsold specials.');
        $package3->setPrice(24.00);
        $package3->setPhoto(null);
        $package3->setCreatedAt(new \DateTimeImmutable());
        $package3->setCategory($mealsCategory);
        $package3->setBusiness($business1);
        $manager->persist($package3);

        // --- Orders ---
        $order1 = new Order();
        $order1->setCreatedAt(new \DateTimeImmutable());
        $order1->setPackage($package1);
        $order1->setConsumer($consumer1);
        $manager->persist($order1);

        $order2 = new Order();
        $order2->setCreatedAt(new \DateTimeImmutable());
        $order2->setPackage($package2);
        $order2->setConsumer($consumer2);
        $manager->persist($order2);

        $manager->flush();
    }
}
