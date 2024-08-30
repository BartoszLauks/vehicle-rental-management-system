<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AbstractsApiController;
use App\DTO\Depot\DepotDTO;
use App\DTO\Transformer\DepotResponseDTOTransformer;
use App\Entity\Depot;
use App\Factory\DepotFactory;
use App\Paginator\Paginator;
use App\Repository\DepotRepository;
use App\Validator\MultiFieldValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/admin/depot', name: 'api_admin_depot_', format: 'json')]
class DepotController extends AbstractsApiController//AbstractController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly DepotFactory $depotFactory,
        private readonly DepotRepository $depotRepository,
        private readonly MultiFieldValidator $multiFieldValidator,
        private readonly Paginator $paginator,
        private readonly DepotResponseDTOTransformer $depotResponseDTOTransformer,
    ) {
        parent::__construct($this->serializer);
    }

    #[Route('', name: 'create', methods: 'POST')]
    public function addDepot(#[MapRequestPayload(
        serializationContext: ['groups' => ['depot:default']]
    )] DepotDTO $depotDTO): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->multiFieldValidator->validate($depotDTO, ['depot:default']);
        $depot = $this->depotFactory->createFromDTO($depotDTO);

        $this->depotRepository->save($depot);

        return $this->json(['message' => 'Depot was created'], Response::HTTP_CREATED);
    }

    #[Route('', name: 'index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $queryBuilder = $this->depotRepository->findWithFilters();

        $paginator = $this->paginator->createPaginator(
            $queryBuilder,
            (int) $request->get('page', Paginator::PAGINATION_DEFAULT_PAGE),
            (int) $request->get('limit', Paginator::PAGINATION_DEFAULT_LIMIT),
            (int) $request->get('perPage', Paginator::PAGINATION_DEFAULT_PER_PAGE)
        );

        $dtos = $this->depotResponseDTOTransformer->transformFromObjects($paginator);
        $paginatedResponse = $this->paginator->createPaginatedResponse($dtos, $paginator);

        return $this->respond($paginatedResponse, ['depot:default']);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(Depot $depot): Response
    {
        $dto = $this->depotResponseDTOTransformer->transformFromObject($depot);

        return $this->respond($dto, ['depot:default']);
    }
}