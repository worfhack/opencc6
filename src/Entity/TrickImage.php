<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickImageRepository")
 */
class TrickImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="trickImages")
     * @ORM\JoinColumn(nullable=false)

     */
    private $trickList;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image" ,  inversedBy="trickImages" )
     * @ORM\JoinColumn(name="image_list", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $imageList;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $thumbnail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrickList(): ?Trick
    {
        return $this->trickList;
    }

    public function setTrickList(?Trick $trick): self
    {
        $this->trickList = $trick;

        return $this;
    }

    public function getImageList(): ?Image
    {
        return $this->imageList;
    }

    public function getPath()
    {

        return $this->getImageList()->getPath();
    }
    public function setImageList(?Image $image): self
    {
        $this->imageList = $image;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }



    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getThumbnail(): ?bool
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?bool $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}
