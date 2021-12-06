<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva
 *
 * @ORM\Table(name="tva")
 * @ORM\Entity(repositoryClass="App\Repository\TvaRepository");
 */
class Tva
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tva", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTva;

    /**
     * @var float
     *
     * @ORM\Column(name="taux_tva", type="float", precision=10, scale=0, nullable=false)
     */
    private $tauxTva;

    public function getIdTva(): ?int
    {
        return $this->idTva;
    }

    public function getTauxTva(): ?float
    {
        return $this->tauxTva;
    }

    public function setTauxTva(float $tauxTva): self
    {
        $this->tauxTva = $tauxTva;

        return $this;
    }


}
