<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="fk_produit_id_tva", columns={"id_tva"}), @ORM\Index(name="fk_produit_id_categorie", columns={"id_categorie"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository");
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="text", length=65535, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="pu_ht", type="float", precision=10, scale=0, nullable=false)
     */
    private $puHt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="images", type="text", length=0, nullable=true, options={"default"="NULL"})
     */
    private $images = 'NULL';

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    private $idCategorie;

    /**
     * @var \Tva
     *
     * @ORM\ManyToOne(targetEntity="Tva")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tva", referencedColumnName="id_tva")
     * })
     */
    private $idTva;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Declinaison", inversedBy="produit")
     * @ORM\JoinTable(name="produit_declinaison",
     *   joinColumns={
     *     @ORM\JoinColumn(name="produit_id", referencedColumnName="id_produit")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="declinaison_id", referencedColumnName="id_declinaison")
     *   }
     * )
     */
    private $declinaison;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Declinaison", mappedBy="idProduit")
     */
    private $idDeclinaison;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->declinaison = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idDeclinaison = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPuHt(): ?float
    {
        return $this->puHt;
    }

    public function setPuHt(float $puHt): self
    {
        $this->puHt = $puHt;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getIdTva(): ?Tva
    {
        return $this->idTva;
    }

    public function setIdTva(?Tva $idTva): self
    {
        $this->idTva = $idTva;

        return $this;
    }

    /**
     * @return Collection|Declinaison[]
     */
    public function getDeclinaison(): Collection
    {
        return $this->declinaison;
    }

    public function addDeclinaison(Declinaison $declinaison): self
    {
        if (!$this->declinaison->contains($declinaison)) {
            $this->declinaison[] = $declinaison;
        }

        return $this;
    }

    public function removeDeclinaison(Declinaison $declinaison): self
    {
        $this->declinaison->removeElement($declinaison);

        return $this;
    }

    /**
     * @return Collection|Declinaison[]
     */
    public function getIdDeclinaison(): Collection
    {
        return $this->idDeclinaison;
    }

    public function addIdDeclinaison(Declinaison $idDeclinaison): self
    {
        if (!$this->idDeclinaison->contains($idDeclinaison)) {
            $this->idDeclinaison[] = $idDeclinaison;
            $idDeclinaison->addIdProduit($this);
        }

        return $this;
    }

    public function removeIdDeclinaison(Declinaison $idDeclinaison): self
    {
        if ($this->idDeclinaison->removeElement($idDeclinaison)) {
            $idDeclinaison->removeIdProduit($this);
        }

        return $this;
    }

}
