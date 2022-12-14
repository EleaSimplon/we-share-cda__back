<?php

namespace App\Entity;

use App\Repository\FeaturesLabelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(

    collectionOperations: [
        'get'=>[
            'normalization_context'=> ['groups'=>[ 'read:featuresLabel:collection' ]]
        ],
        'post' =>[
            'denormalization_context'=> ['groups'=>['featuresLabel:write']],
        ],
    ],
    itemOperations: [
        'put',
        'delete',
        'get',
    ],

    normalizationContext: ['groups' => 'activity:read', 'featuresLabel:read'],
)]
#[ORM\Entity(repositoryClass: FeaturesLabelRepository::class)]
class FeaturesLabel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['activity:read','featuresLabel:read', 'read:featuresLabel:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['activity:read', 'featuresLabel:read', 'read:featuresLabel:collection'])]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'features_label', targetEntity: Features::class)]
    #[Groups(['featuresLabel:read', 'read:featuresLabel:collection'])]
    private Collection $features;

    public function __construct()
    {
       $this->features = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

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
            //$feature->setActivity($this);
        }

        return $this;
    }

    public function removeFeatures(Features $features): self
    {
        if ($this->features->removeElement($features)) {
            // set the owning side to null (unless already changed)
            if ($features->getFeaturesLabel() === $this) {
                $features->setFeaturesLabel(null);
            }
        }

        return $this;
    }

    // Admin
    public function __toString()
    {
       return $this->label;
    }
}
