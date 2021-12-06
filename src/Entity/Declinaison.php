<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Declinaison
 *
 * @ORM\Table(name="declinaison")
 * @ORM\Entity(repositoryClass="App\Repository\DeclinaisonRepository");
 */
class Declinaison
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_declinaison", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDeclinaison;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Produit", mappedBy="declinaison")
     */
    private $produit;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Produit", inversedBy="idDeclinaison")
     * @ORM\JoinTable(name="stock",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_declinaison", referencedColumnName="id_declinaison")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_produit", referencedColumnName="id_produit")
     *   }
     * )
     */
    private $idProduit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produit = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idProduit = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdDeclinaison(): ?int
    {
        return $this->idDeclinaison;
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

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->addDeclinaison($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            $produit->removeDeclinaison($this);
        }

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getIdProduit(): Collection
    {
        return $this->idProduit;
    }

    public function addIdProduit(Produit $idProduit): self
    {
        if (!$this->idProduit->contains($idProduit)) {
            $this->idProduit[] = $idProduit;
        }

        return $this;
    }

    public function removeIdProduit(Produit $idProduit): self
    {
        $this->idProduit->removeElement($idProduit);

        return $this;
    }

}
