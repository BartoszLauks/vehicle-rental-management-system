<?php

namespace App\Controller;

use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LegacyMetricsController extends AbstractController
{
    public function __construct(
        private readonly VehicleRepository $vehicleRepository,
    ) {
    }

    #[Route('/legacy/metrics', name: 'app_legacy_metrics', )]
    public function index(): Response
    {

        $lines = [
            '# HELP count_vehicle_brand Quantity vehicle brand',
            '# TYPE count_vehicle_brand gauge',
        ];

        foreach ($this->vehicleRepository->getCountVehicleByBrandGrouping() as ['name' => $name, 'COUNT' => $count]) {
            $metric = sprintf('count_vehicle_brand{count="%s"}', $name);
            $lines[] = sprintf('%s %d', $metric, $count);
        }

        return new Response(implode(PHP_EOL, $lines), 200, ['Content-type' => 'text/plain']);
    }
}
