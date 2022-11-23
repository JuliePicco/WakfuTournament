<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table(name="`character`")
 */
class Character
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
    private $characterName;

    /**
     * @ORM\ManyToOne(targetEntity=ClassCharacter::class, inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=Gender::class, inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender;

    /**
     * @ORM\ManyToOne(targetEntity=Server::class, inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $server;

    /**
     * @ORM\ManyToOne(targetEntity=Nation::class, inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nation;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $guild;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;





    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCharacterName(): ?string
    {
        return $this->characterName;
    }

    public function setCharacterName(string $characterName): self
    {
        $this->characterName = $characterName;

        return $this;
    }


    public function getClassCharacter(): ?ClassCharacter
    {
        return $this->classCharacter;
    }

    public function setClassCharacter(?ClassCharacter $classCharacter): self
    {
        $this->classCharacter = $classCharacter;

        return $this;
    }


    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

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


    public function getNation(): ?Nation
    {
        return $this->nation;
    }

    public function setNation(?Nation $nation): self
    {
        $this->nation = $nation;

        return $this;
    }


    public function getGuild(): ?string
    {
        return $this->guild;
    }

    public function setGuild(?string $guild): self
    {
        $this->guild = $guild;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }



    


   

}
