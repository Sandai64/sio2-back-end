<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list_product", "list_category", "meta_category"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"list_product", "list_category", "meta_category"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"list_category", "meta_category"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=2048)
     * @Groups({"list_product", "list_category"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups("list_category")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("list_category")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"list_product", "list_category"})
     */
    private $is_hidden;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="id_category")
     * @Groups({"list_category", "detail_category"})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getIsHidden(): ?bool
    {
        return $this->is_hidden;
    }

    public function setIsHidden(bool $is_hidden): self
    {
        $this->is_hidden = $is_hidden;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setIdCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getIdCategory() === $this) {
                $product->setIdCategory(null);
            }
        }

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
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTime();
    }
}
