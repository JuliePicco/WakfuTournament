<?php

namespace App\Entity;

use App\Repository\TournamentModeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TournamentModeRepository::class)
 */
class TournamentMode
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
    private $modeName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPlayersByTeam;

    /**
     * @ORM\OneToMany(targetEntity=Tournament::class, mappedBy="mode")
     */
    private $tournaments;


    public function __construct()
    {
        $this->tournaments = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getModeName(): ?string
    {
        return $this->modeName;
    }

    public function setModeName(string $modeName): self
    {
        $this->modeName = $modeName;

        return $this;
    }


    public function getNbPlayersByTeam(): ?int
    {
        return $this->nbPlayersByTeam;
    }

    public function setNbPlayersByTeam(?int $nbPlayersByTeam): self
    {
        $this->nbPlayersByTeam = $nbPlayersByTeam;

        return $this;
    }

    
    /**
     * @return Collection<int, Tournament>
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): self
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments[] = $tournament;
            $tournament->setMode($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            // set the owning side to null (unless already changed)
            if ($tournament->getMode() === $this) {
                $tournament->setMode(null);
            }
        }

        return $this;
    }
}
