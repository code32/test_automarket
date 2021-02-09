<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }


    /**
     * Get fresh cars
     *
     * @return \App\Entity\Car[]
     */
    public function getFreshCars()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.received', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
            ;
    }


    /**
     * Get cars by filter
     *
     * @param array $options
     * @return \App\Entity\Car[]
     */
    public function getFilterCars(Array $options)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        if (isset($options["new"])) {
            if ($options["new"] === 1) {
                $queryBuilder->andWhere('c.new_car = 1');
            }
            if ($options["new"] === 0) {
                $queryBuilder->andWhere('c.new_car = 0');
            }
        }

        if (isset($options["release_year_from"]) && is_integer($options["release_year_from"])) {
            $queryBuilder->andWhere('c.release_year >= :release_year_from')->setParameter('release_year_from', $options["release_year_from"]);
        }

        if (isset($options["release_year_to"]) && is_integer($options["release_year_to"])) {
            $queryBuilder->andWhere('c.release_year <= :release_year_to')->setParameter('release_year_to', $options["release_year_to"]);
        }

        if (isset($options["price_from"]) && is_numeric($options["price_from"])) {
            $queryBuilder->andWhere('c.price >= :price_from')->setParameter('price_from', $options["price_from"]);
        }

        if (isset($options["price_to"]) && is_numeric($options["price_to"])) {
            $queryBuilder->andWhere('c.price <= :price_to')->setParameter('price_to', $options["price_to"]);
        }

        if (isset($options["rain_sensor"])) {
            if ($options["rain_sensor"] === 1) {
                $queryBuilder->andWhere('c.rain_sensor = 1');
            }
            if ($options["rain_sensor"] === 0) {
                $queryBuilder->andWhere('c.rain_sensor = 0');
            }
        }

        if (isset($options["brand"]) && is_integer($options["brand"])) {
            $queryBuilder->andWhere('c.brand = :brand')->setParameter('brand', $options["brand"]);
        }

        return $queryBuilder->getQuery()->getResult();
    }


    /**
     * Mileage over $mileage km reduction on $reductionPercentage percentage
     *
     * @param $mileage
     * @param $reductionPercentage
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function mileageReduction(float $mileage, float $reductionPercentage)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $cars = $this->getCarsByMileageMore($mileage);

        /** @var Car $car */
        foreach ($cars as $car) {
            $mileage = $car->getMileage();
            $mileage -= $mileage / 100.0 * $reductionPercentage;
            $car->setMileage($mileage);

            $em->persist($car);
            $em->flush();
        }
    }


    /**
     * Get cars whose mileage exceeds
     *
     * @param float $mileage Vehicle mileage
     * @return mixed
     */
    private function getCarsByMileageMore(float $mileage)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.mileage > :mileage_target')->setParameter('mileage_target', $mileage)
            ->getQuery()
            ->getResult()
            ;
    }
}
