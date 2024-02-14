<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
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
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $datefin;

    /**
     * @ORM\Column(type="string")
     */
    private $nb_inscription;

    /**
     * @ORM\ManyToMany(targetEntity=Employe::class, inversedBy="projets")
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="projets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Employe::class, inversedBy="projectsorganize")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateur;

    /**
     * @ORM\Column(type="text")
     */
    private $infos_project;

    public function __construct()
    {
        $this->employee = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getNbInscription(): ?int
    {
        return $this->nb_inscription;
    }

    public function setNbInscription(int $nb_inscription): self
    {
        $this->nb_inscription = $nb_inscription;

        return $this;
    }

    /**
     * @return Collection<int, Employe>
     */
    public function getEmployee(): Collection
    {
        return $this->employee;
    }

    public function addEmployee(Employe $employee): self
    {
        if (!$this->employee->contains($employee)) {
            $this->employee[] = $employee;
            $employee->addProjet($this);
        }

        return $this;
    }

    public function removeEmployee(Employe $employee): self
    {
        if($this->employee->removeElement($employee))
        {
            $employee->removeProjet($this);
        }
        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getOrganisateur(): ?Employe
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Employe $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getInfosProject(): ?string
    {
        return $this->infos_project;
    }

    public function setInfosProject(string $infos_project): self
    {
        $this->infos_project = $infos_project;

        return $this;
    }
}
