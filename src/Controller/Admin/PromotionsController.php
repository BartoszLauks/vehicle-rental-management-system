<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Attribute\ValidateNonEmptyBody;
use App\Controller\AbstractsApiController;
use App\DTO\Promotions\PromotionsDTO;
use App\DTO\Promotions\PromotionsResponseDTO;
use App\DTO\Transformer\PromotionsResponseDTOTransformer;
use App\Entity\Promotions;
use App\Enum\DiscountsEnum;
use App\Factory\PromotionsFactory;
use App\Repository\PromotionsRepository;
use App\Updater\PromotionsUpdater;
use App\Validator\MultiFieldValidator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/admin/promotions', name: 'api_admin_promotions_', format: 'json')]
class PromotionsController extends AbstractsApiController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly MultiFieldValidator $multiFieldValidator,
        private readonly PromotionsFactory $promotionsFactory,
        private readonly PromotionsRepository $promotionsRepository,
        private readonly PromotionsUpdater $promotionsUpdater,
        private readonly PromotionsResponseDTOTransformer $promotionsResponseDTOTransformer,
    ) {
        parent::__construct($this->serializer);
    }

    #[Route('', name: 'create', methods: 'POST')]
    #[ValidateNonEmptyBody]
    public function createPromotions(#[MapRequestPayload(
        serializationContext: ['groups' => ['promotions:default']]
    )] PromotionsDTO $promotionsDTO): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->multiFieldValidator->validate($promotionsDTO, ['promotions:default']);
        $promotions = $this->promotionsFactory->createFromDTO($promotionsDTO);

        $this->promotionsRepository->save($promotions);

        return $this->json(['message' => 'Promotions was create.'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'patch')]
    #[ValidateNonEmptyBody]
    public function patchPromotions(#[MapRequestPayload(
        serializationContext: ['groups' => ['promotions:default']]
    )] PromotionsDTO $promotionsDTO, Promotions $promotions): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->multiFieldValidator->validate($promotionsDTO, ['promotions:default']);
        $this->promotionsUpdater->patch($promotions, $promotionsDTO);

        $promotionsDTO = $this->promotionsResponseDTOTransformer->transformFromObject($promotions);
        $this->promotionsRepository->flush();

        return $this->respond($promotionsDTO, ['promotions:default']);
    }
}