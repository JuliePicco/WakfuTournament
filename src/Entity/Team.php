<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $teamName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $teamLogo="team-default.jpg";

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Server::class, inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $server;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="leaderTeams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $leader;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="teams")
     */
    private $members;

    /**
     * @ORM\ManyToMany(targetEntity=Tournament::class, mappedBy="participatingTeams")
     */
    private $tournaments;


    public function __construct()
    {   
        $this->creationDate = new DateTime();
        $this->members = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }


    public function getTeamLogo(): ?string
    {
        return $this->teamLogo;
    }

    public function setTeamLogo(?string $teamLogo): self
    {
        $this->teamLogo = $teamLogo;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }



    public function getCreationDate(): ?\DateTimeInterface
    {
        
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }


    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function setServer(?Server $server): self
    {
        $this->server = $server;

        return $this;
    }



    public function getLeader(): ?User
    {
        return $this->leader;
    }
    public function setLeader(?User $leader): self
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->addTeam($this);
        }

        return $this;
    }

    public function removeMember(User $member): self
    {
        if ($this->members->removeElement($member)) {
            $member->removeTeam($this);
        }

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
            $tournament->addParticipatingTeam($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            $tournament->removeParticipatingTeam($this);
        }

        return $this;
    }


    // Fonction permettant de savoir combien y a t'il de membre dans l'équipe

    public function nbMembers(){
        $nbMembers = count($this->members);
        return $nbMembers;
    }

   
    public function __toString()
    {
        return $this->teamName;
    }

    
}
