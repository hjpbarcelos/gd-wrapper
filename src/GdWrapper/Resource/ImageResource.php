<?php
/**
 * Creates class \GdWrapper\Resource
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

/**
 * Concrete implementation of a wrapper for GD2 image resource type.
 */
class ImageResource implements Resource
{
    /**
     * @var int The image width
     */
    private $width = null;

    /**
     * @var int The image height
     */
    private $height = null;

    /**
     * @var resource A raw GD2 image resource.
     */
    private $raw;

    /**
     * Creates a new wrapper to a raw GD2 image resource.
     *
     * @param resource $resource A valid GD2 image resource.
     *
     * @throws \InvalidArgumentException If <code>$resource</code> is not a
     * 		valid resource.
     */
    public function __construct($resource)
    {
        $this->setRaw($resource);
    }

    /**
     * Destroys the image resource if it still exists.
     */
    final public function __destruct()
    {
        if (is_resource($this->raw)) {
            imagedestroy($this->raw);
        }
    }

    /**
     * Clones the current object.
     *
     * @return ImageResource
     */
    final public function __clone()
    {
        $this->raw = $this->cloneResource();
    }

    /**
     * Clones this object's raw resource.
     *
     * @return resource
     */
    private function cloneResource()
    {
        return self::cloneGdResource($this->raw);
    }
    
    /**
     * Workarround method for cloning a GD2 image resource.
     *
     * @param resource $resource
     *
     * @return resource
     */
    private static function cloneGdResource($resource) {
        ob_start();
        imagegd2($resource);
        return imagecreatefromstring(ob_get_clean());
    }
    
    /**
     * {@inheritdoc}
     *
     * @see \GdWrapper\Resource\Resource::setRaw()
     */
    public function setRaw($resource)
    {
        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Invalid resource passed to ' . get_class($this));
        }
        $this->raw = self::cloneGdResource($resource);
    }

    /**
     * {@inheritdoc}
     *
     * @see \GdWrapper\Resource\Resource::getRaw()
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * {@inheritdoc}
     *
     * @see \GdWrapper\Resource\Resource::setWidth()
     */
    public function getWidth()
    {
        if ($this->width === null) {
            $this->width = imagesx($this->raw);
        }
        return $this->width;
    }

    /**
     * {@inheritdoc}
     *
     * @see \GdWrapper\Resource\Resource::setHeight()
     */
    public function getHeight()
    {
        if ($this->height === null) {
            $this->height = imagesy($this->raw);
        }
        return $this->height;
    }
}