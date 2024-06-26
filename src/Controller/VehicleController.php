<?php

namespace App\Controller;

use App\DTO\Transformer\VehicleResponseDTOTransformer;
use App\Entity\Vehicle;
use App\Paginator\Paginator;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/vehicle', name: 'api_vehicle_', format: 'json')]
class VehicleController extends AbstractController
{
    public function __construct(
        private readonly VehicleRepository $vehicleRepository,
        private readonly Paginator $paginator,
        private readonly VehicleResponseDTOTransformer $vehicleResponseDTOTransformer,
    ) {
    }

    #[Route('', name: 'index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $filters = $request->query->all();
        $queryBuilder = $this->vehicleRepository->findWithFilters($filters);

        $paginator = $this->paginator->createPaginator(
            $queryBuilder,
            (int) $request->get('page', Paginator::PAGINATION_DEFAULT_PAGE),
            (int) $request->get('limit', Paginator::PAGINATION_DEFAULT_LIMIT),
            (int) $request->get('perPage', Paginator::PAGINATION_DEFAULT_PER_PAGE),
        );

        $dtos = $this->vehicleResponseDTOTransformer->transformFromObjects($paginator);
        $paginatedResponse = $this->paginator->createPaginatedResponse($dtos, $paginator);

        return $this->json($paginatedResponse, Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(Vehicle $vehicle): Response
    {
        $dto = $this->vehicleResponseDTOTransformer->transformFromObject($vehicle);

        return $this->json($dto, Response::HTTP_OK);
    }
}
