<?php

namespace App\Controller\Admin;

use App\Controller\AbstractsApiController;
use App\DTO\Transformer\VehicleResponseDTOTransformer;
use App\DTO\Vehicle\VehicleDTO;
use App\Entity\Vehicle;
use App\Factory\VehicleFactory;
use App\Repository\VehicleRepository;
use App\Updater\VehicleUpdater;
use App\Validator\MultiFieldValidator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/admin/vehicle', name: 'api_admin_vehicle_', format: 'json')]
class VehicleController extends AbstractsApiController//AbstractController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly MultiFieldValidator $multiFieldValidator,
        private readonly VehicleFactory $vehicleFactory,
        private readonly VehicleRepository $vehicleRepository,
        private readonly VehicleUpdater $vehicleUpdater,
        private readonly VehicleResponseDTOTransformer $vehicleResponseDTOTransformer,
    ) {
        parent::__construct($this->serializer);
    }

    #[Route('', name: 'create', methods: 'POST')]
    public function addVehicle(#[MapRequestPayload(
        serializationContext: ['groups' => ['vehicle:default', 'brand:default']]
    )] VehicleDTO $vehicleDTO): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->multiFieldValidator->validate($vehicleDTO, ['vehicle:default', 'brand:default']);
        $vehicle = $this->vehicleFactory->createFromDTO($vehicleDTO);

        $this->vehicleRepository->save($vehicle);

        return $this->json(['message' => 'Vehicle was create.'] ,Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'patch', methods: 'PATCH')]
    public function patchVehicle(#[MapRequestPayload(
        serializationContext: ['groups' => ['vehicle:default', 'brand:default']]
    )] VehicleDTO $vehicleDTO, Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->multiFieldValidator->validate($vehicleDTO, ['vehicle:patch', 'brand:default']);
        $this->vehicleUpdater->patch($vehicle, $vehicleDTO);

        $vehicleDTO = $this->vehicleResponseDTOTransformer->transformFromObject($vehicle);
        $this->vehicleRepository->flush();

        return $this->respond($vehicleDTO, ['vehicle:default', 'brand:default']);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function deleteVehicle(Vehicle $vehicle): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->vehicleRepository->delete($vehicle);

        return $this->json(['message' =>'Vehicle was deleted'], Response::HTTP_OK);
    }
}
