<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //TODO: use hautelook/AliceBundle
        //I am not using hautelook/AliceBundle because it's too much for
        //simple fixtures like this.
        for ($i = 0; $i < 20; $i++) {
            $category[$i] = new Category();
            $category[$i]->setName('category '.$i);
            $manager->persist($category[$i]);
        }

        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setCategory($category[rand(0, 9)]);
            $product->setCategory($category[rand(10, 19)]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
