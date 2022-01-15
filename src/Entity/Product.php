<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list_product", "list_category", "detail_category"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list_product", "detail_category"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"list_product", "detail_category"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"list_product"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"list_product"})
     */
    private $updated_at;

    /**
     * @ORM\Column(type="float")
     * @Groups({"list_product", "detail_category"})
     */
    private $price_tax_free;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"list_product", "detail_category"})
     */
    private $image_b64;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"list_product", "detail_category"})
     */
    private $is_hidden;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"list_product"})
     */
    private $id_category;

    /**
     * @ORM\Column(type="string", length=2048)
     * @Groups({"list_product", "detail_category"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=ProductKind::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"list_product"})
     */
    private $id_product_kind;

    /**
     * @ORM\ManyToOne(targetEntity=Tax::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"list_product"})
     */
    private $tax_id;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getPriceTaxFree(): ?float
    {
        return $this->price_tax_free;
    }

    public function setPriceTaxFree(float $price_tax_free): self
    {
        $this->price_tax_free = $price_tax_free;

        return $this;
    }

    public function getImageB64(): ?string
    {
        return $this->image_b64;
    }

    public function setImageB64(?string $image_b64): self
    {
        $this->image_b64 = $image_b64;

        return $this;
    }

    public function getIsHidden(): ?bool
    {
        return $this->is_hidden;
    }

    public function setIsHidden(bool $is_hidden): self
    {
        $this->is_hidden = $is_hidden;

        return $this;
    }

    public function getIdCategory(): ?Category
    {
        return $this->id_category;
    }

    public function setIdCategory(?Category $id_category): self
    {
        $this->id_category = $id_category;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIdProductKind(): ?ProductKind
    {
        return $this->id_product_kind;
    }

    public function setIdProductKind(?ProductKind $id_product_kind): self
    {
        $this->id_product_kind = $id_product_kind;

        return $this;
    }

    public function getTaxId(): ?Tax
    {
        return $this->tax_id;
    }

    public function setTaxId(?Tax $tax_id): self
    {
        $this->tax_id = $tax_id;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        // Set created_at & updated_at
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTime();

        if (is_null($this->image_b64))
        {
            $this->image_b64 = 'data:image/jpeg;base64,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';
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTime();
    }
}
