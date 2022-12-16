<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NewsRepository;

/**
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 */
class News
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $newsTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $newsContent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $newsIllustration="news-default.jpg";

    /**
     * @ORM\Column(type="datetime")
     */
    private $newsCreationDate;

    
    public function __construct()
    {
        $this->newsCreationDate = new DateTime();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewsTitle(): ?string
    {
        return $this->newsTitle;
    }

    public function setNewsTitle(string $newsTitle): self
    {
        $this->newsTitle = $newsTitle;

        return $this;
    }

    public function getNewsContent(): ?string
    {
        return $this->newsContent;
    }

    public function setNewsContent(string $newsContent): self
    {
        $this->newsContent = $newsContent;

        return $this;
    }

    public function getNewsIllustration(): ?string
    {
        return $this->newsIllustration;
    }

    public function setNewsIllustration(?string $newsIllustration): self
    {
        $this->newsIllustration = $newsIllustration;

        return $this;
    }

    public function getNewsCreationDate(): ?\DateTimeInterface
    {
        return $this->newsCreationDate;
    }

    public function setNewsCreationDate(\DateTimeInterface $newsCreationDate): self
    {
        $this->newsCreationDate = $newsCreationDate;

        return $this;
    }
}
