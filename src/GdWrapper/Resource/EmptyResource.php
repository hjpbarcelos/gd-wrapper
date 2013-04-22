<?php
/**
 * Defines EmptyResource class.
 *
 * @author Henrique Barcelos
 */

namespace GdWrapper\Resource;

/**
 * Defines a true color image resource.
 */
class EmptyResource extends AbstractResource {
    /**
     * @var int The image width
     */
    private $width = null;
    
    /**
     * @var int The image height
     */
    private $height = null;
    
    /**
     * Creates a new blank image resource.
     *
     * @param int $width The width of the new image.
     * @param int $height The height of the new image.
     * @throws \InvalidArgumentException If `$width` or `$height` are less than zero.
     */
    public function __construct($width, $height)
    {
        if ((int) $width <= 0 || (int) $height <= 0) {
            throw new \InvalidArgumentException(
                "Imposible to create an image with dimensions [{$width}, {$height}]"
            );
        }
        
        $this->width = (int) $width;
        $this->height = (int) $height;
        
        $raw = imagecreatetruecolor($this->width, $this->height);
        $this->setRaw($raw);
        imagedestroy($raw);
    }
    
    /**
     * {@inheritdoc}
     *
     * @see \GdWrapper\Resource\Resource::setWidth()
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * {@inheritdoc}
     *
     * @see \GdWrapper\Resource\Resource::setHeight()
     */
    public function getHeight()
    {
        return $this->height;
    }
}