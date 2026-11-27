<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    public function __construct(
        private readonly LocationRepository $locations,
        private readonly MeasurementRepository $measurements
    ) {}
    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurements->findByLocation($location);
    }

    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $result = $this->locations->findOneBy([
            'country' => $countryCode,
            'city' => $city
        ]);

        return $this->getWeatherForLocation($result);
    }
}
