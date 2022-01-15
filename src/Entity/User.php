<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list_users"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"list_users"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"list_users"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"detail_user"})
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=BlogPage::class, mappedBy="username")
     * @Groups({"list_users"})
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $blogPage->setUsername($this);
        }

        return $this;
    }

    public function removeBlogPage(BlogPage $blogPage): self
    {
        if ($this->blogPages->removeElement($blogPage)) {
            // set the owning side to null (unless already changed)
            if ($blogPage->getUsername() === $this) {
                $blogPage->setUsername(null);
            }
        }

        return $this;
    }
}
