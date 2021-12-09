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
     * @ORM\Column(type="string", length=8096, nullable=true)
     * @Groups({"list_product", "detail_category"})
     */
    private $image_path;

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

    public function getImagePath(): ?string
    {
        return $this->image_path;
    }

    public function setImagePath(?string $image_path): self
    {
        $this->image_path = $image_path;

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

        if (is_null($this->image_path))
        {
            $this->image_path = 'default.jpg';
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
