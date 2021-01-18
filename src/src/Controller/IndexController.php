<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/fresh", name="fresh")
     * @param CarRepository $carRepository
     * @return Response
     */
    public function fresh(CarRepository $carRepository): Response
    {
        $cars = [];
        $errors = [];

        $result = $carRepository->getFreshCars();
        /** @var Car $resultItem */
        foreach ($result as $car) {
            $cars[] = self::getSafeResult($car);
        }

        return new JsonResponse([
            'errors' => $errors,
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/filter", name="filter")
     * @param CarRepository $carRepository
     * @param Request $request
     * @return Response
     */
    public function filter(CarRepository $carRepository, Request $request): Response
    {
        $cars = [];
        $errors = [];
        $data = null;

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE ) {
            $errors[] = "Error in JSON request";
            return new JsonResponse([
                'errors' => $errors,
                'cars' => $data
            ]);
        }

        if (is_array($data)) {
            $result = $carRepository->getFilterCars($data);
            /** @var Car $resultItem */
            foreach ($result as $car) {
                $cars[] = self::getSafeResult($car);
            }
        }

        return new JsonResponse([
            'errors' => $errors,
            'cars' => $cars
        ]);
    }

    /**
     * Get array safe car data for json
     *
     * @param Car $car
     * @return array
     */
    private static function getSafeResult(Car $car) {
        return [
            "id" => $car->getId(),
            "brand" => $car->getBrand()->getTitle(),
            "new" => $car->getNewCar(),
            "release_year" => $car->getReleaseYear(),
            "price" => $car->getPrice(),
            "rain_sensor" => $car->getRainSensor(),
            "received" => $car->getReceived()->format('d.m.Y H:i'),
            "mileage" => $car->getMileage(),
        ];
    }
}
