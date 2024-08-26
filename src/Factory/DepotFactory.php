<?php

declare(strict_types=1);

namespace App\Factory;

use App\DTO\Depot\DepotDTO;
use App\Entity\Depot;

final readonly class DepotFactory
{
    public function createFromDTO(DepotDTO $depotDTO): Depot
    {
        $depot = new Depot();
        $depot->setName($depotDTO->name);
        $depot->setCity($depotDTO->city);
        $depot->setPostalCode($depotDTO->postalCode);
        $depot->setStreet($depotDTO->street);
        $depot->setNumber($depotDTO->number);
        $depot->setPhone($depotDTO->phone);
        $depot->setEmailContact($depotDTO->emailContact);
        $depot->setLongitude($depotDTO->longitude);
        $depot->setLatitude($depotDTO->latitude);

        return $depot;
    }
}