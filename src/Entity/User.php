<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles;
    /**
     * @ORM\Column(nullable=false)
     */
    private $password;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */

    private $firstname;

    /**
     * @Assert\Email()
     * @ORM\Column(type="string", length=255,nullable=false)
     */

    private $email;

    /**
    @ORM\Column(type="string", length=255, nullable=true)
     */

    private $lastname;

    /**
     * @Assert\DateTime()
     * @ORM\Column(type="datetime", nullable=true)
     */

    private $birthday;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="user")
     */
    private $videos;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->roles = array('ROLE_USER');
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword( $password)
    {
        $this->password = $password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return Collection|video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setUser($this);
        }

        return $this;
    }

    public function removeVideo(video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getUser() === $this) {
                $video->setUser(null);
            }
        }

        return $this;
    }


}
