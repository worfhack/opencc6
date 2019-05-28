<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickVideoRepository")
 */
class TrickVideo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="trickVideos")
     * @ORM\JoinColumn(nullable=false)

     */
    private $trickList;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Video" ,  inversedBy="trickVideos" )
     * @ORM\JoinColumn(name="video_list", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $videoList;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

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

    public function getVideoList(): ?Video
    {
        return $this->videoList;
    }

    public function getUrl()
    {

        return $this->getVideoList()->getUrl();
    }
    public function setVideoList(?Video $video): self
    {
        $this->videoList = $video;

        return $this;
    }



    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
