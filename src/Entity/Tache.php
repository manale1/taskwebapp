<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TacheRepository::class)
 */
class Tache
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $designation;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $date_fin;

    /**
     * @ORM\Column(type="json")
     */
    private $parametres = [];

    /**
     * @ORM\ManyToOne(targetEntity=client::class, inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_client;

    /**
     * @ORM\ManyToOne(targetEntity=statut::class, inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_statut;

    /**
     * @ORM\ManyToOne(targetEntity=outil::class, inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_outil;

    /**
     * @ORM\ManyToOne(targetEntity=employe::class, inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_employe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getParametres(): ?string
    {
        return json_encode($this->parametres);
    }

    public function setParametres(array $parametres): self
    {
        $this->parametres = $parametres;
        return $this;
    }

    public function getIdEmploye(): ?employe
    {
        return $this->id_employe;
    }

    public function setIdEmploye(?employe $id_employe): self
    {
        $this->id_employe = $id_employe;

        return $this;
    }

    public function getIdClient(): ?client
    {
        return $this->id_client;
    }

    public function setIdClient(?client $id_client): self
    {
        $this->id_client = $id_client;

        return $this;
    }

    public function getIdStatut(): ?statut
    {
        return $this->id_statut;
    }

    public function setIdStatut(?statut $id_statut): self
    {
        $this->id_statut = $id_statut;

        return $this;
    }

    public function getIdOutil(): ?outil
    {
        return $this->id_outil;
    }

    public function setIdOutil(?outil $id_outil): self
    {
        $this->id_outil = $id_outil;

        return $this;
    }
}
