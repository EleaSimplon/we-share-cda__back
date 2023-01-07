<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ActivityController;
use App\Controller\ActivityImageController;
use Symfony\Component\Serializer\Annotation\Groups;

// For the image


#[ApiResource(

    collectionOperations: [
        'get'=>[
            'normalization_context'=> ['groups'=>['read:activities:collection']]
        ],
        // 'post' =>[
        //     'denormalization_context'=> ['groups'=>['activity:write']],
        // ],
        // Pour la doc API
        'post'=>[
            'method' => 'POST',
            'path' => '/prepare',
            'controller' => [ActivityController::class, 'suggestActivity'],
            'denormalization_context'=> ['groups'=>['activity:write']]

            
        ],
        // 'prepare' => [
        //     'method' => 'POST',
        //     'path' => '/suggest_activity',
        //     'controller' => [ActivityController::class, 'suggest_activity']
        // ]
    ],
    itemOperations: [
        'put',
        'delete',
        'get',
        'image' => [
            'method' => 'POST',
            'path' => '/activities/{id}/image',
            'deserialize' => false,
            'validate'=>false,
            'controller' => ActivityImageController::class
        ]

        // 'prepare'
        /*  method post,
            utiliser un controller
            recuperer dans la requete les ids
            Créer une methode dans le activityRepository qui recupere les activities cc.voir requete sql du patron
            renvoyer les activities (return idiote !!!!!)
        */
    ],

    normalizationContext: ['groups' => 'activity:read'],
)]
#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'activity:read', 'review:write', 'read:activities:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $company = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $schedule = null;

    #[ORM\Column]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?int $duration = null;

    #[ORM\ManyToOne(cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?Unit $unit = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $country = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?\DateTimeInterface $published_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?int $price = null;

    #[ORM\Column(length: 700)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'activity:write', 'activity:read', 'read:activities:collection'])]
    private ?string $short_description = null;

    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['activity:write', 'activity:read', 'read:activities:collection'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: Review::class)]
    #[Groups(['user:write', 'activity:read', 'read:activities:collection'])]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: Features::class)]
    #[Groups(['activity:write', 'activity:read',  'read:activities:collection'])]
    private Collection $features;
    
    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->features = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(?string $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setPublishedAt(?\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $short_description): self
    {
        $this->short_description = $short_description;

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

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setActivity($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getActivity() === $this) {
                $review->setActivity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Features>
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Features $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features->add($feature);
            $feature->setActivity($this);
        }

        return $this;
    }

    public function removeFeature(Features $feature): self
    {
        if ($this->features->removeElement($feature)) {
            // set the owning side to null (unless already changed)
            if ($feature->getActivity() === $this) {
                $feature->setActivity(null);
            }
        }

        return $this;
    }

    // Admin : get unit type when adding an activity
    public function __toString()
    {
        return $this->name;
    }

}
