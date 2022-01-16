<?php

namespace App\Entity;

use App\Repository\BlogPageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BlogPageRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class BlogPage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list_posts", "list_categories"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"list_posts", "list_categories"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"list_posts"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"list_posts", "list_categories"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"list_posts", "list_categories"})
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=2048)
     * @Groups({"list_posts", "list_categories"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=BlogCategory::class, inversedBy="blogPages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"list_posts"})
     */
    private $id_blog_category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="blogPages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"list_posts"})
     */
    private $username;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIdBlogCategory(): ?BlogCategory
    {
        return $this->id_blog_category;
    }

    public function setIdBlogCategory(?BlogCategory $id_blog_category): self
    {
        $this->id_blog_category = $id_blog_category;

        return $this;
    }

    public function getUsername(): ?User
    {
        return $this->username;
    }

    public function setUsername(?User $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @ORM\PrePersist
    */
    public function setMetadata() : void
    {
        $this->slug = strtolower($this->title);
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
