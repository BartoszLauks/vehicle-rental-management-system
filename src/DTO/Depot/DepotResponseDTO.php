<?php

declare(strict_types=1);

namespace App\DTO\Depot;

use Symfony\Component\Serializer\Annotation\Groups;

class DepotResponseDTO
{
    #[Groups(['depot:default'])]
    public int $id;
    #[Groups(['depot:default'])]
    public string $name;
    #[Groups(['depot:default'])]
    public string $city;
    #[Groups(['depot:default'])]
    public string $postalCode;
    #[Groups(['depot:default'])]
    public string $street;
    #[Groups(['depot:default'])]
    public string $number;
    #[Groups(['depot:default'])]
    public string $phone;
    #[Groups(['depot:default'])]
    public string $emailContact;
    #[Groups(['depot:default'])]
    public float $longitude;
    #[Groups(['depot:default'])]
    public float $latitude;
}
