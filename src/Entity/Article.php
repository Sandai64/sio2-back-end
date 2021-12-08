<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="fk_article_id_rubrique", columns={"id_rubrique"}), @ORM\Index(name="fk_article_id_employe", columns={"id_employe"})})
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository");
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_article", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="text", length=65535, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", length=65535, nullable=false)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \Employe
     *
     * @ORM\ManyToOne(targetEntity="Employe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_employe", referencedColumnName="id_employe")
     * })
     */
    private $idEmploye;

    /**
     * @var \Rubrique
     *
     * @ORM\ManyToOne(targetEntity="Rubrique")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rubrique", referencedColumnName="id_rubrique")
     * })
     */
    private $idRubrique;

    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getIdEmploye(): ?Employe
    {
        return $this->idEmploye;
    }

    public function setIdEmploye(?Employe $idEmploye): self
    {
        $this->idEmploye = $idEmploye;

        return $this;
    }

    public function getIdRubrique(): ?Rubrique
    {
        return $this->idRubrique;
    }

    public function setIdRubrique(?Rubrique $idRubrique): self
    {
        $this->idRubrique = $idRubrique;

        return $this;
    }


}
