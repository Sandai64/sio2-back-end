<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoleEmploye
 *
 * @ORM\Table(name="role_employe")
 * @ORM\Entity(repositoryClass="App\Repository\RoleEmployeRepository");
 */
class RoleEmploye
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_role", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRole;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_role", type="text", length=65535, nullable=false)
     */
    private $nomRole;

    public function getIdRole(): ?int
    {
        return $this->idRole;
    }

    public function getNomRole(): ?string
    {
        return $this->nomRole;
    }

    public function setNomRole(string $nomRole): self
    {
        $this->nomRole = $nomRole;

        return $this;
    }


}
