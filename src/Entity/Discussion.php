<?php

namespace App\Entity;

use App\Repository\DiscussionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscussionRepository::class)]
class Discussion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $relation;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'discussions')]
    private $User;

    #[ORM\OneToMany(mappedBy: 'discussion', targetEntity: Message::class)]
    private $Message;

    #[ORM\ManyToMany(targetEntity: InBox::class, mappedBy: 'Discussion')]
    private $inBoxes;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->Message = new ArrayCollection();
        $this->inBoxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->User->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessage(): Collection
    {
        return $this->Message;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->Message->contains($message)) {
            $this->Message[] = $message;
            $message->setDiscussion($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->Message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDiscussion() === $this) {
                $message->setDiscussion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InBox>
     */
    public function getInBoxes(): Collection
    {
        return $this->inBoxes;
    }

    public function addInBox(InBox $inBox): self
    {
        if (!$this->inBoxes->contains($inBox)) {
            $this->inBoxes[] = $inBox;
            $inBox->addDiscussion($this);
        }

        return $this;
    }

    public function removeInBox(InBox $inBox): self
    {
        if ($this->inBoxes->removeElement($inBox)) {
            $inBox->removeDiscussion($this);
        }

        return $this;
    }
}
