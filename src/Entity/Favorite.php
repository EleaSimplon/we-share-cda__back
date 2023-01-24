<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FavoriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get'=>[
            'normalization_context'=> ['groups'=>[ 'read:favorites:collection']]
        ],
        'post' =>[
            'denormalization_context'=> ['groups'=>['favorite:write']],
        ]
    ],
    itemOperations: [
        'put',
        'delete',
        'get',
        
    ],
    normalizationContext: ['groups' => 'favorite:read'],
)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['favorite:read', 'activity:read'])]
    private ?int $id = null;
    #[Groups(['favorite:read', 'favorite:write', 'activity:read'])]
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favorites')]
    private Collection $user;

    #[Groups(['favorite:write', 'user:read'])]
    #[ORM\ManyToMany(targetEntity: Activity::class, inversedBy: 'favorites')]
    private Collection $activity;

    #[Groups(['favorite:write', 'activity:read'])]
    #[ORM\Column]
    private ?bool $isFavorite = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->activity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivity(): Collection
    {
        return $this->activity;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activity->contains($activity)) {
            $this->activity->add($activity);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        $this->activity->removeElement($activity);

        return $this;
    }

    public function isIsFavorite(): ?bool
    {
        return $this->isFavorite;
    }

    public function setIsFavorite(bool $isFavorite): self
    {
        $this->isFavorite = $isFavorite;

        return $this;
    }
}
