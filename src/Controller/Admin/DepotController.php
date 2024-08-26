<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\DTO\Depot\DepotDTO;
use App\Factory\DepotFactory;
use App\Repository\DepotRepository;
use App\Validator\MultiFieldValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/admin/depot', name: 'api_admin_depot_', format: 'json')]
class DepotController extends AbstractController
{
    public function __construct(
        private readonly DepotFactory $depotFactory,
        private readonly DepotRepository $depotRepository,
        private readonly MultiFieldValidator $multiFieldValidator,
    ) {
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

//    #[Route('', name: 'index', methods: 'GET')]
//    public function index(): Response
//    {
//
//    }
}