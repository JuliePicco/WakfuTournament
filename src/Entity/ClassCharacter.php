<?php

namespace App\Entity;

use App\Repository\ClassCharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassCharacterRepository::class)
 */
class ClassCharacter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $className;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgFemale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgMale;

    /**
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="classCharacter", orphanRemoval=true)
     */
    private $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClassName(): ?string
    {
        return $this->className;
    }

    public function setClassName(string $className): self
    {
        $this->className = $className;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getImgFemale(): ?string
    {
        return $this->imgFemale;
    }

    public function setImgFemale(string $imgFemale): self
    {
        $this->imgFemale = $imgFemale;

        return $this;
    }

    public function getImgMale(): ?string
    {
        return $this->imgMale;
    }

    public function setImgMale(string $imgMale): self
    {
        $this->imgMale = $imgMale;

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
            $character->setClassCharacter($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getClassCharacter() === $this) {
                $character->setClassCharacter(null);
            }
        }

        return $this;
    }


    
}
