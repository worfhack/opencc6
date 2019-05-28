<?php
/**
 * Created by PhpStorm.
 * User: worf
 * Date: 24/04/19
 * Time: 16:26
 */

namespace App\Service;

use phpthumb;

class SnowPhpthumb
{

    protected $phpthumb;

    protected $targetDirectoryBase;
    protected $targetDirectoryBanner;
    protected $targetDirectoryMin;
    protected $banner_width;
    protected $min_width;


    public function __construct($targetDirectoryBase, $targetDirectoryBanner, $targetDirectoryMin, $banner_width, $min_width)
    {
        $this->phpthumb = new phpthumb();
        $this->targetDirectoryBase = $targetDirectoryBase;
        $this->targetDirectoryBanner = $targetDirectoryBanner;
        $this->targetDirectoryMin = $targetDirectoryMin;
        $this->banner_width = $banner_width;
        $this->min_width = $min_width;

    }

    public function resize($src)
    {

        //dump($this->phpthumb);
        $this->phpthumb->setSourceFilename($this->targetDirectoryBase.'/' . $src);
        $this->phpthumb->setParameter('w', $this->banner_width);
        $this->phpthumb->GenerateThumbnail();
        $this->phpthumb->RenderToFile($this->targetDirectoryBanner.'/' . $src);

        $this->phpthumb->resetObject();
        $this->phpthumb->setSourceFilename($this->targetDirectoryBase.'/' . $src);
        $this->phpthumb->setParameter('w', $this->min_width);
        $this->phpthumb->GenerateThumbnail();
        $this->phpthumb->RenderToFile($this->targetDirectoryMin.'/' . $src);


    }
}