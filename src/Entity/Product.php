<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $sku = null;

    #[ORM\Column(length: 250)]
    private ?string $product_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $update_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): static
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeInterface $update_at): static
    {
        $this->update_at = $update_at;

        return $this;
    }

  // These hooks aren't working for some reason. Set them manually.
  //  /**
  //    * @ORM\PrePersist
  //    */
  //   public function setTimestampsOnCreate(): void
  //   {
  //       $this->created_at = new \DateTimeImmutable();
  //   }

  //   /**
  //    * @ORM\PreUpdate
  //    */
  //   public function setTimestampsOnUpdate(): void
  //   {
  //       $this->update_at = new \DateTimeImmutable();
  //   }

    public function updateFromPayload(array $payload): void
    {
        // SKU is a unique identifier
        $sku = $payload['sku'] ?? null;

        if ($sku !== null) {
            $this->setProductName($payload['product_name'] ?? $this->getProductName());
            $this->setDescription($payload['description'] ?? $this->getDescription());
            $this->setUpdateAt(new \DateTimeImmutable());
        }
    }
}
