<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_USER"];

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $pseudonyme;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar="profil-default.png";
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $discordId;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private ?string $discordPseudo="Non renseigné";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $twitchId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitchLink="Non renseigné";

    /**
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="user")
     */
    private $characters;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="members")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="leader", orphanRemoval=true)
     */
    private $leaderTeams;

    /**
     * @ORM\OneToMany(targetEntity=Tournament::class, mappedBy="organisator")
     */
    private $tournaments;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=Topic::class, mappedBy="user")
     */
    private $topics;


    
    public function __construct()
    {
        $this->creationDate = new DateTime();
        $this->characters = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->leaderTeams = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->topics = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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

   
    public function getPseudonyme(): ?string
    {
        return $this->pseudonyme;
    }

    public function setPseudonyme(string $pseudonyme): self
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }


    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }


    public function isVerified(): bool
    {
        return $this->isVerified;
    }
    
    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;
        
        return $this;
    }


    public function getDiscordId(): ?string
    {
        return $this->discordId;
    }

    public function setDiscordId(?string $discordId): self
    {
        $this->discordId = $discordId;

        return $this;
    }
    

    public function getDiscordPseudo(): ?string
    {
        return $this->discordPseudo;
    }
    
    public function setDiscordPseudo(?string $discordPseudo): self
    {
        $this->discordPseudo = $discordPseudo;
        
        return $this;
    }


    public function getTwitchId(): ?string
    {
        return $this->twitchId;
    }

    public function setTwitchId(?string $twitchId): self
    {
        $this->twitchId = $twitchId;

        return $this;
    }
    

    public function getTwitchLink(): ?string
    {
        return $this->twitchLink;
    }
    
    public function setTwitchLink(?string $twitchLink): self
    {
        $this->twitchLink = $twitchLink;
        
        return $this;
    }
    
    
    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }
    
    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->setUser($this);
        }
        
        return $this;
    }
    
    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getUser() === $this) {
                $character->setUser(null);
            }
        }
        
        return $this;
    }


    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        $this->teams->removeElement($team);

        return $this;
    }


    /**
     * @return Collection<int, Team>
     */
    public function getLeaderTeams(): Collection
    {
        return $this->leaderTeams;
    }

    public function addLeaderTeam(Team $leaderTeam): self
    {
        if (!$this->leaderTeams->contains($leaderTeam)) {
            $this->leaderTeams[] = $leaderTeam;
            $leaderTeam->setLeader($this);
        }

        return $this;
    }

    public function removeLeaderTeam(Team $leaderTeam): self
    {
        if ($this->leaderTeams->removeElement($leaderTeam)) {
            // set the owning side to null (unless already changed)
            if ($leaderTeam->getLeader() === $this) {
                $leaderTeam->setLeader(null);
            }
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
            $tournament->setOrganisator($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            // set the owning side to null (unless already changed)
            if ($tournament->getOrganisator() === $this) {
                $tournament->setOrganisator(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setUser($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getUser() === $this) {
                $topic->setUser(null);
            }
        }

        return $this;
    }


    // Fonction qui permet de compter le nombre de fois ou on est leader d une team

      public function nbLeaderTeams(){

        $nbLeaderTeams = count($this->leaderTeams);

        return $nbLeaderTeams;
    }



    //Fonction qui permet de compter le nombre d'équipe dans lequel on est présent

    public function nbTeams(){

        $nbTeams = count($this->teams);

        return $nbTeams;
    }


    // Fonction qui permet de compter le nombre de tournois créés

    public function nbTournaments(){

        $nbTournaments = count($this->tournaments);

        return $nbTournaments;
    }

 
    public function __toString()
    {
        return $this->pseudonyme;
    }

   




  

  
    
}
