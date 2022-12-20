<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FeaturesValueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;


#[ApiResource(

    collectionOperations: [
        'get'=>[
            'normalization_context'=> ['groups'=>[ 'read:featuresValue:collection', 'read:featuresLabel:collection' ]]
        ],
        'post' =>[
            'denormalization_context'=> ['groups'=>['featuresValue:write']],
        ],
    ],
    itemOperations: [
        'put',
        'delete',
        'get',
    ],

    normalizationContext: ['groups' => 'activity:read', 'featuresValue:read'],
)]

#[ORM\Entity(repositoryClass: FeaturesValueRepository::class)]
class FeaturesValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['activity:read','featuresValue:read', 'read:featuresValue:collection', 'read:featuresLabel:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['activity:read', 'featuresValue:read', 'read:featuresValue:collection', 'read:featuresLabel:collection'])]
    private ?string $value = null;

    #[ORM\OneToMany(mappedBy: 'features_value', targetEntity: Features::class)]
    #[Groups(['featuresValue:read'])]
    private Collection $features;

    public function __construct()
    {
        //$this->features = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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
            $feature->setFeaturesValue($this);
        }

        return $this;
    }

    public function removeFeature(Features $feature): self
    {
        if ($this->features->removeElement($feature)) {
            // set the owning side to null (unless already changed)
            if ($feature->getFeaturesValue() === $this) {
                $feature->setFeaturesValue(null);
            }
        }

        return $this;
    }

    // Admin
    public function __toString()
    {
       return $this->value;
    }

}
