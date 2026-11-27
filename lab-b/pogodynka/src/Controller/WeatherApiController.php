<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

final class WeatherApiController extends AbstractController
{
    public function __construct(
        private readonly WeatherUtil $weatherUtil
    )
    {}
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] bool $json,
    ): Response
    {
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);

        if ($json) {
            return $this->json([
                'city' => $city,
                'country' => $country,
                'measurements' => array_map(fn(Measurement $m) => [
                    'date' => $m->getDate()->format('Y-m-d'),
                    'celsius' => $m->getCelcius(),
                ], $measurements),
            ]);
        }
        $csv = "city,country,date,celsius\n";
        $csv .= implode("\n", array_map(fn(Measurement $m) => implode(',', [
            $city,
            $country,
            $m->getDate()->format('Y-m-d'),
            $m->getCelcius(),
        ]), $measurements));

        return new Response($csv, Response::HTTP_OK, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
