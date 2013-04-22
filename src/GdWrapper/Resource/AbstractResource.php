<?php
/**
 * Defines AbstractResource class.
 *
 * @author Henrique Barcelos
 */

namespace GdWrapper\Resource;

/**
 * Abstract representation of a resource.
 */
abstract class AbstractResource implements Resource
{
    /**
     * @var resource A raw GD2 image resource.
     */
    private $raw;
    
    /**
     * Creates a new wrapper to a raw GD2 image resource.
     *
     * IMPORTANT: to guarantee that two `Resource` objects do not have the
     * same image resource, this constructor creates a copy of `$resource`
     * parameter and only then assigns the copy to `$raw` attribute.
     *
     * Functions that creates resources JUST to be used in theese objects SHOULD
     * destroy it right after instanciate an object to prevent memory leaks.
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
        $this->raw = $this->cloneGdResource($this->raw);
    }
    
    /**
     * Workarround method for cloning a GD2 image resource.
     *
     * @param resource $resource
     *
     * @return resource
     */
    private function cloneGdResource($resource) {
        ob_start();
        imagegd2($resource);
        return imagecreatefromstring(ob_get_clean());
    }
    
    /**
     * Sets a GD2 image resource to this wrapper object.
     *
     * IMPORTANT: to guarantee that two `Resource` objects do not have the
     * same image resource, this method creates a copy of `$resource`
     * parameter and only then assigns the copy to `$raw` attribute.
     *
     * @param resource $resource A valid GD2 image resource.
     *
     * @return void
     *
     * @throws \InvalidArgumentException If <code>$resource</code> is not a
     * 		valid resource.
     */
    protected function setRaw($resource)
    {
        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Invalid resource passed to ' . get_class($this));
        }
        $this->raw = $this->cloneGdResource($resource);
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
    
    
}