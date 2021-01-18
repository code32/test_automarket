<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Brands
        $brandFord = new Brand();
        $brandFord->setTitle("Ford");
        $manager->persist($brandFord);

        $brandAudi = new Brand();
        $brandAudi->setTitle("Audi");
        $manager->persist($brandAudi);

        $brandHonda = new Brand();
        $brandHonda->setTitle("Honda");
        $manager->persist($brandHonda);

        $brandToyota = new Brand();
        $brandToyota->setTitle("Toyota");
        $manager->persist($brandToyota);

        // Cars
        $carFordNew = new Car();
        $carFordNew->setBrand($brandFord);
        $carFordNew->setNewCar(true);
        $carFordNew->setMileage(0.0);
        $carFordNew->setPrice(8802847.0);
        $carFordNew->setRainSensor(true);
        $carFordNew->setReleaseYear(2021);
        $carFordNew->setReceived(new \DateTime("2021-01-10 10:40:00"));
        $manager->persist($carFordNew);

        $carFordNew2 = new Car();
        $carFordNew2->setBrand($brandFord);
        $carFordNew2->setNewCar(true);
        $carFordNew2->setMileage(0.0);
        $carFordNew2->setPrice(10267522.0);
        $carFordNew2->setRainSensor(true);
        $carFordNew2->setReleaseYear(2021);
        $carFordNew2->setReceived(new \DateTime("2021-01-05 13:00:00"));
        $manager->persist($carFordNew2);

        $carAudiOld = new Car();
        $carAudiOld->setBrand($brandAudi);
        $carAudiOld->setNewCar(false);
        $carAudiOld->setMileage(7200.0);
        $carAudiOld->setPrice(2980000.0);
        $carAudiOld->setRainSensor(false);
        $carAudiOld->setReleaseYear(2019);
        $carAudiOld->setReceived(new \DateTime("2021-01-12 16:00:00"));
        $manager->persist($carAudiOld);

        $carAudiOld2 = new Car();
        $carAudiOld2->setBrand($brandAudi);
        $carAudiOld2->setNewCar(false);
        $carAudiOld2->setMileage(193211.0);
        $carAudiOld2->setPrice(375000.0);
        $carAudiOld2->setRainSensor(false);
        $carAudiOld2->setReleaseYear(2004);
        $carAudiOld2->setReceived(new \DateTime("2021-01-09 15:30:00"));
        $manager->persist($carAudiOld2);

        $carAudiOld3 = new Car();
        $carAudiOld3->setBrand($brandAudi);
        $carAudiOld3->setNewCar(false);
        $carAudiOld3->setMileage(195000.0);
        $carAudiOld3->setPrice(780000.0);
        $carAudiOld3->setRainSensor(false);
        $carAudiOld3->setReleaseYear(2013);
        $carAudiOld3->setReceived(new \DateTime("2021-01-09 11:10:00"));
        $manager->persist($carAudiOld3);

        $manager->flush();
    }
}
