<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction", indexes={@ORM\Index(name="fk_transaction_id_produit", columns={"id_produit"}), @ORM\Index(name="fk_transaction_id_statut", columns={"id_statut"}), @ORM\Index(name="fk_transaction_id_declinaison", columns={"id_declinaison"})})
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository");
 */
class Transaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_transaction", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTransaction;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_ht", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixHt;

    /**
     * @var \Declinaison
     *
     * @ORM\ManyToOne(targetEntity="Declinaison")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_declinaison", referencedColumnName="id_declinaison")
     * })
     */
    private $idDeclinaison;

    /**
     * @var \StatutCommande
     *
     * @ORM\ManyToOne(targetEntity="StatutCommande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_statut", referencedColumnName="id_statut")
     * })
     */
    private $idStatut;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id_produit")
     * })
     */
    private $idProduit;

    public function getIdTransaction(): ?int
    {
        return $this->idTransaction;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixHt(): ?float
    {
        return $this->prixHt;
    }

    public function setPrixHt(float $prixHt): self
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    public function getIdDeclinaison(): ?Declinaison
    {
        return $this->idDeclinaison;
    }

    public function setIdDeclinaison(?Declinaison $idDeclinaison): self
    {
        $this->idDeclinaison = $idDeclinaison;

        return $this;
    }

    public function getIdStatut(): ?StatutCommande
    {
        return $this->idStatut;
    }

    public function setIdStatut(?StatutCommande $idStatut): self
    {
        $this->idStatut = $idStatut;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }


}
