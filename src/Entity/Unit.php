<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UnitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'put',
        'delete',
        'get',
    ],
    normalizationContext: ['groups' => 'unit:read'],
    denormalizationContext: ['groups' => 'unit:write']
)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["unit:read", "activity:read", "activity:write"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["unit:read", "activity:read", "activity:write"])]
    private ?string $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    // Admin : get unit type when adding an activity
    public function __toString()
    {
        return $this->type;
    }
}
