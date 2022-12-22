<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;



#[ApiResource(

    collectionOperations: [
        'get'=>[
            'normalization_context'=> ['groups'=>[ 'read:reviews:collection', 'activity:read' ]]
        ],
        'post' =>[
            'denormalization_context'=> ['groups'=>['review:write']],
        ]
    ],
    itemOperations: [
        'put',
        'delete',
        'get'
    ],

    normalizationContext: ['groups' => 'review:read'],

)]
#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['review:write','review:read', 'read:reviews:collection', 'activity:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['review:write', 'review:read', 'read:reviews:collection', 'activity:read'])]
    private ?int $rate = null;

    #[ORM\Column(length: 255)]
    #[Groups(['review:write', 'review:read', 'read:reviews:collection', 'activity:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 600)]
    #[Groups(['review:write', 'review:read', 'read:reviews:collection', 'activity:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['review:write','review:read', 'read:reviews:collection', 'activity:read'])]
    private ?string $picture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['review:write','review:read', 'read:reviews:collection', 'activity:read'])]
    private ?\DateTimeInterface $posted_at = null;

    #[ORM\ManyToOne(cascade:["persist", "remove"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['review:read', 'review:write', 'read:reviews:collection', 'activity:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reviews', cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([ 'review:write', 'read:reviews:collection'])]
    private ?Activity $activity = null;

    public function __construct()
    {
        $this->posted_at = new DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->posted_at;
    }

    public function setPostedAt(\DateTimeInterface $posted_at): self
    {
        $this->posted_at = $posted_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getActivity(): ?Activity
    {
        return $this->activity;
    }

    public function setActivity(?Activity $activity): self
    {
        $this->activity = $activity;

        return $this;
    }
}
