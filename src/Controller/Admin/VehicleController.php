<?php

namespace App\Controller\Admin;

use App\DTO\Vehicle\VehicleDTO;
use App\Factory\VehicleFactory;
use App\Repository\VehicleRepository;
use App\Validator\MultiFieldValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/vehicle', name: 'api_admin_vehicle_', format: 'json')]
class VehicleController extends AbstractController
{
    public function __construct(
        private readonly MultiFieldValidator $multiFieldValidator,
        private readonly VehicleFactory $vehicleFactory,
        private readonly VehicleRepository $vehicleRepository,
    ) {
    }

    #[Route('', name: 'create', methods: 'POST')]
    public function AddVehicle(#[MapRequestPayload(
        serializationContext: ['groups' => ['vehicle:create', 'brand:create']]
    )] VehicleDTO $vehicleDTO): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->multiFieldValidator->validate($vehicleDTO, ['vehicle:create', 'brand:create']);

        $vehicle = $this->vehicleFactory->createFromDTO($vehicleDTO);

        $this->vehicleRepository->save($vehicle);

        return $this->json('Vehicle create.' ,Response::HTTP_CREATED);
    }
}
