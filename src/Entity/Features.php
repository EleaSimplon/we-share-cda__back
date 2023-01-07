<?php

namespace App\Entity;

use App\Repository\FeaturesRepository;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
//use Doctrine\Common\Collections\ArrayCollection;


#[ApiResource(

    collectionOperations: [
        'get'=>[
            'normalization_context'=> ['groups'=>[ 'read:features:collection', 'read:featuresLabel:collection' ]]
        ],
        'post' =>[
            'denormalization_context'=> ['groups'=>['feature:write']],
        ]
    ],
    itemOperations: [
        'put',
        'delete',
        'get',
    ],

    normalizationContext: ['groups' => 'activity:read', 'features:read', 'featuresLabel:read'],
)]
#[ORM\Entity(repositoryClass: FeaturesRepository::class)]
class Features
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['activity:read', 'features:read', 'read:features:collection', 'featuresLabel:read', 'read:featuresLabel:collection'])]
    private ?int $id = null;

    #[Groups(['features:read', 'read:features:collection'])]
    #[ORM\ManyToOne(inversedBy: 'features')]
    private ?Activity $activity = null;

    #[Groups(['activity:read', 'features:read'])]
    #[ORM\ManyToOne(inversedBy: 'features')]
    private ?FeaturesLabel $features_label = null;

    #[ORM\ManyToOne(inversedBy: 'features')]
    #[Groups(['activity:read', 'features:read','featuresLabel:read', 'read:featuresLabel:collection'])]
    private ?FeaturesValue $features_value = null;


    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFeaturesLabel(): ?FeaturesLabel
    {
        return $this->features_label;
    }

    public function setFeaturesLabel(?FeaturesLabel $features_label): self
    {
        $this->features_label = $features_label;

        return $this;
    }

    // Admin : get unit type when adding an feature value
    public function __toString()
    {
        return $this->id;
    }

    public function getFeaturesValue(): ?FeaturesValue
    {
        return $this->features_value;
    }

    public function setFeaturesValue(?FeaturesValue $features_value): self
    {
        $this->features_value = $features_value;

        return $this;
    }

}
