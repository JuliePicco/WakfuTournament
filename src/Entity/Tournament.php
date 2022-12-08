<?php

namespace App\Entity;

use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TournamentRepository::class)
 */
class Tournament
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=80)
     */
    private $tournamentName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imgTournament="tournament-default.jpg";

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tournaments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisator;

    /**
     * @ORM\ManyToOne(targetEntity=Server::class, inversedBy="tournaments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $server;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=TournamentMode::class, inversedBy="tournaments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionTournament;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $rewardChoice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $reward;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $limitedInscription;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbTeamLimit;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="tournaments")
     */
    private $participatingTeams;




    public function __construct()
    {
        $this->participatingTeams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTournamentName(): ?string
    {
        return $this->tournamentName;
    }

    public function setTournamentName(string $tournamentName): self
    {
        $this->tournamentName = $tournamentName;

        return $this;
    }


    public function getImgTournament(): ?string
    {
        return $this->imgTournament;
    }

    public function setImgTournament(?string $imgTournament): self
    {
        $this->imgTournament = $imgTournament;

        return $this;
    }


    public function getOrganisator(): ?user
    {
        return $this->organisator;
    }

    public function setOrganisator(?user $organisator): self
    {
        $this->organisator = $organisator;

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


    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }


    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }



    public function getMode(): ?TournamentMode
    {
        return $this->mode;
    }

    public function setMode(?TournamentMode $mode): self
    {
        $this->mode = $mode;

        return $this;
    }



    public function getDescriptionTournament(): ?string
    {
        return $this->descriptionTournament;
    }

    public function setDescriptionTournament(?string $descriptionTournament): self
    {
        $this->descriptionTournament = $descriptionTournament;

        return $this;
    }
    

    public function getRewardChoice(): ?string
    {
        return $this->rewardChoice;
    }

    public function setRewardChoice(string $rewardChoice): self
    {
        $this->rewardChoice = $rewardChoice;

        return $this;
    }


    public function getReward(): ?string
    {
        return $this->reward;
    }

    public function setReward(?string $reward): self
    {
        $this->reward = $reward;

        return $this;
    }


    public function getLimitedInscription(): ?string
    {
        return $this->limitedInscription;
    }

    public function setLimitedInscription(?string $limitedInscription): self
    {
        $this->limitedInscription = $limitedInscription;

        return $this;
    }

    public function getNbTeamLimit(): ?int
    {
        return $this->nbTeamLimit;
    }

    public function setNbTeamLimit(?int $nbTeamLimit): self
    {
        $this->nbTeamLimit = $nbTeamLimit;

        return $this;
    }


    
    /**
     * @return Collection<int, Team>
     */
    public function getParticipatingTeams(): Collection
    {
        return $this->participatingTeams;
    }

    public function addParticipatingTeam(Team $participatingTeam): self
    {
        if (!$this->participatingTeams->contains($participatingTeam)) {
            $this->participatingTeams[] = $participatingTeam;
        }

        return $this;
    }

    public function removeParticipatingTeam(Team $participatingTeam): self
    {
        $this->participatingTeams->removeElement($participatingTeam);

        return $this;
    }


    //permet de connaitre le nombre de place restante dans un tournois limité en place
    public function NbAvailableSpace(){

        $available = $this->nbTeamLimit;
        $reserved = count($this->participatingTeams) ;
        $rest = $available - $reserved;

        return $rest;
    }

    // permet de compter le nombre de place réservé
    public function Nbreserved(){
        $reserved = count($this->participatingTeams) ;
        return $reserved;
    }

    


    

   
}
