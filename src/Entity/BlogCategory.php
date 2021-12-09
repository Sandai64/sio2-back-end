<?php

namespace App\Entity;

use App\Repository\BlogCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogCategoryRepository::class)
 */
class BlogCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=BlogPage::class, mappedBy="id_blog_category")
     */
    private $blogPages;

    public function __construct()
    {
        $this->blogPages = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|BlogPage[]
     */
    public function getBlogPages(): Collection
    {
        return $this->blogPages;
    }

    public function addBlogPage(BlogPage $blogPage): self
    {
        if (!$this->blogPages->contains($blogPage)) {
            $this->blogPages[] = $blogPage;
            $blogPage->setIdBlogCategory($this);
        }

        return $this;
    }

    public function removeBlogPage(BlogPage $blogPage): self
    {
        if ($this->blogPages->removeElement($blogPage)) {
            // set the owning side to null (unless already changed)
            if ($blogPage->getIdBlogCategory() === $this) {
                $blogPage->setIdBlogCategory(null);
            }
        }

        return $this;
    }
}
