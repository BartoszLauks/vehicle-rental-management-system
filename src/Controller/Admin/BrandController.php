<?php

namespace App\Controller\Admin;

use App\Controller\AbstractsApiController;
use App\DTO\Brand\BrandDTO;
use App\DTO\Transformer\BrandResponseDTOTransformer;
use App\Entity\Brand;
use App\Factory\BrandFactory;
use App\Repository\BrandRepository;
use App\Updater\BrandUpdater;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/admin/brand', name: 'api_admin_brand_', format: 'json')]
class BrandController extends AbstractsApiController
{
    public function __construct(
        readonly SerializerInterface $serializer,
        private readonly BrandRepository $brandRepository,
        private readonly BrandFactory $brandFactory,
        private readonly BrandUpdater $brandUpdater,
        private readonly BrandResponseDTOTransformer $brandResponseDTOTransformer,
    ) {
        parent::__construct($this->serializer);
    }

    #[Route('', name: 'create')]
    public function index(#[MapRequestPayload(
        serializationContext: ['groups' => ['brand:default']],
        validationGroups: ['brand:default'],
        validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
    )] BrandDTO $brandDTO): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $brand = $this->brandFactory->createFromDTO($brandDTO);

        $this->brandRepository->save($brand);

        return $this->json(['message' => 'Brand was created'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'put', methods: 'PUT')]
    public function put(#[MapRequestPayload(
        serializationContext: ['groups' => ['brand:default']],
        validationGroups: ['brand:default'],
        validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
    )] BrandDTO $brandDTO, Brand $brand): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $this->brandUpdater->put($brand, $brandDTO);
        $this->brandRepository->save($brand);
        $dto = $this->brandResponseDTOTransformer->transformFromObject($brand);

        return $this->respond($dto, ['brand:default']);
    }
}
