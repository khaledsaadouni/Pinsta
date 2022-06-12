<?php

namespace App\Entity;

use App\Repository\PostRepository;
use App\utilities\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks()]
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    use TimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $Title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Description;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Likes;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $rating;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'posts')]
    private $Author;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class)]
    private $Comment;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'posts')]
    private $Category;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $imageURL;

    #[ORM\OneToMany(mappedBy: 'Post', targetEntity: Liking::class)]
    private $likings;


    public function __construct()
    {
        $this->Comment = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->likings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->Likes;
    }

    public function setLikes(?int $Likes): self
    {
        $this->Likes = $Likes;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->Comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->Comment->contains($comment)) {
            $this->Comment[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->Comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getImageURL(): ?string
    {
        return $this->imageURL;
    }

    public function setImageURL(?string $imageURL): self
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    /**
     * @return Collection<int, Liking>
     */
    public function getLikings(): Collection
    {
        return $this->likings;
    }

    public function addLiking(Liking $liking): self
    {
        if (!$this->likings->contains($liking)) {
            $this->likings[] = $liking;
            $liking->setPost($this);
        }

        return $this;
    }

    public function removeLiking(Liking $liking): self
    {
        if ($this->likings->removeElement($liking)) {
            // set the owning side to null (unless already changed)
            if ($liking->getPost() === $this) {
                $liking->setPost(null);
            }
        }

        return $this;
    }


}
