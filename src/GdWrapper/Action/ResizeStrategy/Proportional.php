<?php
namespace GdWrapper\Action\ResizeStrategy;

use GdWrapper\Resource\EmptyResourceFactory;

class Proportional implements Strategy
{
    private $maxWidth;
    private $maxHeight;

    public function __construct($maxWidth, $maxHeight)
    {
        $this->setMaxWidth($maxWidth);
        $this->setMaxHeight($maxHeight);
    }

    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;
    }

    public function setMaxHeight($maxHeight)
    {
        $this->maxHeight = $maxHeight;
    }

    public function getNewDimensions($width, $height)
    {
        $width = (int) $width;
        $height = (int) $height;
        
        if ($width == 0 || $height == 0) {
            throw new InvalidArgumentException(
                "Invalid initial dimensions: [{$width}, {$height}]"
            );
        }
        
        $minRatio = min(
            ($this->maxWidth / $width),
            ($this->maxHeight / $height)
        );
        
        return array(
            'width' => $width * $minRatio,
            'height' => $height * $minRatio
        );
    }
}