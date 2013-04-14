<?php
/**
 * Creates class GdWrapper\Resource\
 *  
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

/**
 * Wrapper for GD2 image resource type.
 */
class Resource {
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
	 * @throws \InvalidArgumentException If <code>$resource</code> is not a
	 * 		valid resource.
	 */
	public function __construct($resource) {
		$this->setRaw($resource);
	}
	
	/**
	 * Destroys the image resource if it still exists.
	 */
	final public function __destruct() {
		if (is_resource($this->raw)) {
			imagedestroy($this->raw);
		}
	}
	
	/**
	 * Clones the current object.
	 *
	 * @return AbstractResource
	 */
	final public function __clone()
	{
		$this->raw = $this->cloneResource();
	}
	
	/**
	 * Workarround method for cloning a GD2 image resource.
	 *
	 * @return resource
	 */
	private function cloneResource() {
		ob_start();
		imagegd2($this->raw);
		return imagecreatefromstring(ob_get_clean());
	}
	
	/**
	 * Sets a GD2 image resource to this wrapper object.
	 *
	 * @param resource $resource A valid GD2 image resource.
	 * @return void
	 * @throws \InvalidArgumentException If <code>$resource</code> is not a
	 * 		valid resource.
	 */
	public function setRaw($resource)
	{
		if (!is_resource($resource)) {
			throw new \InvalidArgumentException(
				'Invalid resource passed to ' . get_class($this)
			);
		}
		$this->raw = $resource;
	}
	
	/**
	 * Obtains the raw GD2 image resource of this wrapper object.
	 *
	 * @return resource A valid GD2 image resource.
	 */
	public function getRaw()
	{
		return $this->raw;
	}
	
	/**
	 * Get image width.
	 * 
	 * @return int The image width
	 */
	public function getWidth() {
		if($this->width === null) {
			$this->width = imagesx($this->raw);
		}
		return $this->width;
	}
	
	/**
	 * Get image height.
	 *
	 * @return int The image height
	 */
	public function getHeight() {
		if($this->height === null) {
			$this->height = imagesy($this->raw);
		}
		return $this->height;
	}
}