<?php
namespace GdWrapper\Action\ResizeStrategy;

use GdWrapper\Resource\EmptyResourceFactory;

class Exact implements Strategy
{
    private $width;
    private $height;
    
    public function __construct($width, $height)
    {
        $this->setWidth($width);
        $this->setHeight($height);
    }
    
    public function setWidth($width)
    {
        $this->width = $width;
    }
    
    public function setHeight($height)
    {
        $this->height = $height;
    }
    
    public function getNewDimensions($width, $height)
    {
        return array('width' => $this->width, 'height' => $this->height);
    }
}