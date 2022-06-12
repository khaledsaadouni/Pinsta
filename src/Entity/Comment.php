<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use App\utilities\TimeStamp;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks()]
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    use TimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'Comment')]
    private $post;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    private $author;

    #[ORM\Column(type: 'string', length: 255)]
    private $Comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(string $Comment): self
    {
        $this->Comment = $Comment;

        return $this;
    }
}
