<?php

namespace App\Entity\Gw2Api;

use App\Repository\Gw2Api\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'gw2_api_item')]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $uid = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 55)]
    private ?string $type = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $subtype = null;

    #[ORM\Column(length: 25)]
    private ?string $rarity = null;

    #[ORM\Column(nullable: true)]
    private ?bool $blackmarket = null;

    #[ORM\Column]
    private array $data = [];

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $inventoryManagerTip = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $obteningTip = null;

    #[ORM\ManyToMany(targetEntity: ItemTag::class, inversedBy: 'items')]
    private Collection $tag;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function setUid(int $uid): self
    {
        $this->uid = $uid;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
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

    public function getSubtype(): ?string
    {
        return $this->subtype;
    }

    public function setSubtype(?string $subtype): self
    {
        $this->subtype = $subtype;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function isBlackmarket(): ?bool
    {
        return $this->blackmarket;
    }

    public function setBlackmarket(?bool $blackmarket): self
    {
        $this->blackmarket = $blackmarket;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getInventoryManagerTip(): ?string
    {
        return $this->inventoryManagerTip;
    }

    public function setInventoryManagerTip(?string $inventoryManagerTip): self
    {
        $this->inventoryManagerTip = $inventoryManagerTip;

        return $this;
    }

    public function getObteningTip(): ?string
    {
        return $this->obteningTip;
    }

    public function setObteningTip(?string $obteningTip): self
    {
        $this->obteningTip = $obteningTip;

        return $this;
    }

    /**
     * @return Collection<int, ItemTag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(ItemTag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
        }

        return $this;
    }

    public function removeTag(ItemTag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }
}
