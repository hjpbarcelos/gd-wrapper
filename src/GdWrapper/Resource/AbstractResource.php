<?php
/**
 * Defines AbstractResource class.
 * 
 */
namespace GdWrapper\Resource;

use GdWrapper\Preset;

/**
 * Wrapper for GD2 image resource type.
 * 
 * @uses GdWrapper\Preset
 * @author Henrique Barcelos
 * @package GdWrapper\Resource
 */
abstract class AbstractResource {
	/**
	 * @var resource Keeps a GD2 image resource.
	 */
	private $raw;

	/**
	 * Constructor for AbstractResource objects.
	 * 
	 * This constructor has 2 possible assignatures:
	 * 
	 * 1. `self::__construct($resource})` if you already have a valid resource
	 * 2. `self::__construct($filepath})` will try to create a resource from 
	 * 		a file in `$filepath`
	 * 
	 * @param resource|string $resource A GD2 image resource or a filepath 
	 * 		from which try to create one.
	 * @throws \InvalidArgumentException If constructor 1 is used 
	 * 		and <code>$resource</code> is not a valid resource. 
	 * @throws \InvalidArgumentException If constructor 2 is used
	 * 		and <code>$resource</code> is not a path to a valid file.
	 */
	public function __construct($resource) 
	{
		if (is_string($resource)) {
			$this->createResource($resource);
		} else {
			$this->setRaw($resource);	
		}
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
	public function raw() 
	{
		return $this->raw;
	}

	/**
	 * Tries to create an image resource based on a filepath.
	 * 
	 * @param string $filepath The path to a valid image.
	 * @return resource A new concrete object of type AbstractResource. 
	 * @throws \InvalidArgumentException If <code>$filepath</code> is not a 
	 * 		path to a valid file.
	 */
	private function createResource($filepath) {
		if (!is_file($filepath)) {
			throw new \InvalidArgumentException(
				"Invalid filepath location: {$filepath}"
			);
		}

		$this->setRaw($this->doCreateResource($filepath));
	}

	/**
	 * Creates an image resource based on a valid filepath.
	 * 
	 * @param string $filepath A path to a valid file.
	 * @return resource A new concrete object of type AbstractResource. 
	 */
	abstract protected function doCreateResource($filepath);

	/**
	 * Outputs the resource as an image.
	 * 
	 * If `$filename` points to a file, this method will try
	 * to (over)write it.
	 * 
	 * Otherwise if it is null or just a extension name, like `'png'` or 
	 * 		`'jpeg'`, the output will be send to the browser instead.
	 * 
	 * @param string|null $filename (optional) A filename to save a file or 
	 * 		`null` if you want to send the output the browser. 
	 * @param integer $quality (optional) The quality of the generated image.
	 * 		It MUST be in a range from 0 (worst) to 100 (best) 
	 * @param mixed $additionalParameters (optional) additional parameters
	 * 		to generate output.
	 * @return boolean If resource was succesfully outputed.
	 * @throws \InvalidArgumentException If you are trying to save a file in
	 * 		an inexistent or unwritable directory or if the quality is not 
	 * 		valid.
	 */
	public function output(
		$filename = null, 
		$quality = Preset::IMAGE_QUALITY_MAX,
		$additionalParameters = null
	) {
		if (strpos($filename, '.') === false) {
			$filename = null;
		}
		
		if ($filename !== null) {
			$dirname = pathinfo($filenamem, PATHINFO_DIRNAME);
			$basename = fileinode($filename, PATHINFO_BASENAME);
			
			if(!is_dir($dirname)) {
				throw new \InvalidArgumentException(
					"Could not save file '{$basename}' in inexistent directory
						 '{$dirname}'"
				);
			}
			
			if(!is_writable($dirname)) {
				throw new \InvalidArgumentException(
					"You do not have permissions to save '{$basename}' in 
						directory '{$dirname}'"
				);
			}
		}
		
		if($quality !== null && ($quality < 0 || $quality > Preset::IMAGE_QUALITY_MAX)) {
			throw new \InvalidArgumentException(
				'Image quality should be between 0 and ' 
				. Preset::IMAGE_QUALITY_MAX
				. ", {$quality} was given"
			);
		}
		
		return $this->doOutput($filename, $quality, $additionalParameters);
	}
	
	/**
	 * Actually creates the output.
	 * 
	 * @param string|null $filename (optional) A filename to save a file or 
	 * 		`null` if you want to send the output the browser. 
	 * @param integer $quality (optional) The quality of the generated image.
	 * 		It MUST be in a range from 0 (worst) to 100 (best) 
	 * @param mixed $additionalParameters (optional)
	 * @return boolean If resource was succesfully outputed.
	 */
	abstract protected function doOutput(
		$filename = null, 
		$quality = Preset::IMAGE_QUALITY_MAX,
		$additionalParameters = null
	);

	/**
	 * Returns a concrete instance of a AbstractResource based on the file
	 * extension of `$path`.
	 * 
	 * @param string $path the path to an image file.
	 * @return AbstractResource A concrete implementation of AbstractResource
	 * @throws \DomainException If the file type is not currently supported.
	 * @throws \InvalidArgumentException If <code>$filepath</code> is not a 
	 * 		path to a valid file.
	 */
	public static function factory($path) {
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$className = __NAMESPACE__ . '\\' . ucfirst(strtolower($type)) . 'Resource';
		try {
			return (new \ReflectionClass($className))->newInstance($path);
		} catch(\ReflectionException $e) {
			throw new \DomainException("Extension {$path} not supported!");
		}
	}

	/**
	 * Creates a new AbstractResource concrete instance as a copy of `$orig`.
	 * 
	 * If `$newType` is `null`, this method will just return a clone of the
	 * 		original object.
	 * 
	 * Otherwise it will try to create an instance for the type `$newType`,
	 * hading it a copy of the raw resource of this object in its constructor.
	 * 
	 * This method is useful when you try to convert an image into a
	 * different type.
	 * 
	 * @param AbstractResource $orig The prototype resource.
	 * @param string|null $newType (optional) The desired type of resource. 
	 * @throws \DomainException If <code>$newType</code> is not a currently
	 * 		supported file type.
	 */
	public static function copy(AbstractResource $orig, $newType = null) {
		if ($newType === null) {
			return clone $orig;
		} else {
			$className = __NAMESPACE__ . '\\' . ucfirst(strtolower($newType)) . 'Resource';
			try {
				return (new \ReflectionClass($className))->newInstance($orig->cloneResource());
			} catch(\ReflectionException $e) {
				throw new \DomainException("Extension '{$newType}' not supported!");
			}
		}
	}
}
