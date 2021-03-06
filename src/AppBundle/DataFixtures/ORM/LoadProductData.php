<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Product;
use AppBundle\Enum\CategoryTypeEnum;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProductData implements FixtureInterface
{
    private function randomProduct($productNumber, $type) {
        $product = new Product();

        $start = strtotime("22 March 2016");
        $end = strtotime("10 September 2016");
        $timestamp = mt_rand($start, $end);
        $expirationDate = new \DateTime();
        $expirationDate->setTimestamp($timestamp);

        $product->setName('Article '.$productNumber);
        $product->setCategory($type);
        $product->setDescription("Description de l'article : Article ".$productNumber);
        $product->setExpirationDate($expirationDate);
        $product->setPicture(null);
        $product->setPrice(rand(5, 30));
        $product->setQuantity(rand(25, 100));
        $product->setQuantityAlert(rand(10, 25));
        $product->setReference("P10000".$productNumber);

        return $product;
    }

    public function load(ObjectManager $manager)
    {
        $productNumber = 1;

        for($i = 0; $i < 15; $i++) {
            $product = $this->randomProduct($productNumber, CategoryTypeEnum::TYPE_PLASTIC);
            $productNumber++;

            $manager->persist($product);
        }

        for($i = 0; $i < 15; $i++) {
            $product = $this->randomProduct($productNumber, CategoryTypeEnum::TYPE_STATIONERY);
            $productNumber++;

            $manager->persist($product);
        }

        $manager->flush();
    }
}