<?php

namespace App\Entity;

use App\Repository\FollowRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowRepository::class)]
class Follow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: user::class, inversedBy: 'follows')]
    private $account;

    #[ORM\ManyToOne(targetEntity: user::class, inversedBy: 'follows')]
    private $following;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): ?user
    {
        return $this->account;
    }

    public function setAccount(?user $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getFollowing(): ?user
    {
        return $this->following;
    }

    public function setFollowing(?user $following): self
    {
        $this->following = $following;

        return $this;
    }
}
