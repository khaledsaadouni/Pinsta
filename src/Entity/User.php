<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\utilities\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\HasLifecycleCallbacks()]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimeStamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'string', nullable: true)]
    private $roles;

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 50)]
    private $email;

    #[ORM\Column(type: 'string', length: 50)]
    private $country;

    #[ORM\Column(type: 'string', length: 50)]
    private $Name;

    #[ORM\Column(type: 'string', length: 50)]
    private $Firstname;

    #[ORM\Column(type: 'date', length: 50, nullable: true)]
    private $Birthday;

    #[ORM\OneToMany(mappedBy: 'Author', targetEntity: Post::class)]
    private $posts;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class)]
    private $comments;

    #[ORM\ManyToMany(targetEntity: Discussion::class, mappedBy: 'User')]
    private $discussions;

    #[ORM\ManyToMany(targetEntity: Message::class, mappedBy: 'User')]
    private $messages;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pdp;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bio;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $coverIm;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Follow::class)]
    private $follows;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: Liking::class)]
    private $likings;


    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->follows = new ArrayCollection();
        $this->likings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->id;
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
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): self
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getBirthday(): ?string
    {
        return $this->Birthday;
    }

    public function setBirthday(string $Birthday): self
    {
        $this->Birthday = $Birthday;

        return $this;
    }

    public function __toString(): string
    {
        return $this->username;
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
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Discussion>
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions[] = $discussion;
            $discussion->addUser($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussions->removeElement($discussion)) {
            $discussion->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->addUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            $message->removeUser($this);
        }

        return $this;
    }

    public function getPdp(): ?string
    {
        return $this->pdp;
    }

    public function setPdp(?string $pdp): self
    {
        $this->pdp = $pdp;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->cover_image;
    }

    public function setCoverImage(?string $cover_image): self
    {
        $this->cover_image = $cover_image;

        return $this;
    }

    public function getCoverIm(): ?string
    {
        return $this->coverIm;
    }

    public function setCoverIm(?string $coverIm): self
    {
        $this->coverIm = $coverIm;

        return $this;
    }

    /**
     * @return Collection<int, Follow>
     */
    public function getFollows(): Collection
    {
        return $this->follows;
    }

    public function addFollow(Follow $follow): self
    {
        if (!$this->follows->contains($follow)) {
            $this->follows[] = $follow;
            $follow->setAccount($this);
        }

        return $this;
    }

    public function removeFollow(Follow $follow): self
    {
        if ($this->follows->removeElement($follow)) {
            // set the owning side to null (unless already changed)
            if ($follow->getAccount() === $this) {
                $follow->setAccount(null);
            }
        }

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
            $liking->setUser($this);
        }

        return $this;
    }

    public function removeLiking(Liking $liking): self
    {
        if ($this->likings->removeElement($liking)) {
            // set the owning side to null (unless already changed)
            if ($liking->getUser() === $this) {
                $liking->setUser(null);
            }
        }

        return $this;
    }


}
