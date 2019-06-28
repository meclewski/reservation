<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChildRepository")
 */
class Child
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $childName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $parentName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $parentEmail;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $parentPhone;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Lesson", inversedBy="children")
     */
    private $lesson;

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmed;

    public function __construct()
    {
        $this->lesson = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChildName(): ?string
    {
        return $this->childName;
    }

    public function setChildName(string $childName): self
    {
        $this->childName = $childName;

        return $this;
    }

    public function getParentName(): ?string
    {
        return $this->parentName;
    }

    public function setParentName(string $parentName): self
    {
        $this->parentName = $parentName;

        return $this;
    }

    public function getParentEmail(): ?string
    {
        return $this->parentEmail;
    }

    public function setParentEmail(string $parentEmail): self
    {
        $this->parentEmail = $parentEmail;

        return $this;
    }

    public function getParentPhone(): ?string
    {
        return $this->parentPhone;
    }

    public function setParentPhone(string $parentPhone): self
    {
        $this->parentPhone = $parentPhone;

        return $this;
    }

    /**
     * @return Collection|Lesson[]
     */
    public function getLesson(): Collection
    {
        return $this->lesson;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lesson->contains($lesson)) {
            $this->lesson[] = $lesson;
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lesson->contains($lesson)) {
            $this->lesson->removeElement($lesson);
        }

        return $this;
    }

    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }
}
