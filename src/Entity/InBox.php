<?php

namespace App\Entity;

use App\Repository\InBoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InBoxRepository::class)]
class InBox
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Discussion::class, inversedBy: 'inBoxes')]
    private $Discussion;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $User;

    public function __construct()
    {
        $this->Discussion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Discussion>
     */
    public function getDiscussion(): Collection
    {
        return $this->Discussion;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->Discussion->contains($discussion)) {
            $this->Discussion[] = $discussion;
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        $this->Discussion->removeElement($discussion);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
