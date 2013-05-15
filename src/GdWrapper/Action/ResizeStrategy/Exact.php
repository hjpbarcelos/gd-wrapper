<?php
/**
 * Defines the Exact resizing strategy.
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\ResizeStrategy;

/**
 * Represents an exact resizing. That is, no matter which are the original
 * dimensions of an image file, the new dimensions should be exaclty as
 * they are told to be.
 */
class Exact implements Strategy
{
	/**
	 * @var int The width of the resized image.
	 */
    private $width;
    
    /**
     * @var int The height of the resized imaged.
     */
    private $height;
    
    /**
     * Creates an exact resizing strategy.
     *
     * @param int $width The desired width of the image.
     * @param int $height The desired height of the image.
     */
    public function __construct($width, $height)
    {
        $this->setWidth($width);
        $this->setHeight($height);
    }
    
    /**
     * Sets the desired width of the image.
     *
     * @param int $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = (int) $width;
    }
    
    /**
     * Gets the desired width of the image.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * Sets the desired width of the image.
     *
     * @param int $height
     * @return void
     */
    public function setHeight($height)
    {
        $this->height = (int) $height;
    }
    
    /**
     * Gets the desired height of the image.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * {@inheritdoc}
     *
     * @see GdWrapper\Action\ResizeStrategy\Strategy::getNewDimensions()
     */
    public function getNewDimensions($width, $height)
    {
        return array('width' => $this->width, 'height' => $this->height);
    }
}