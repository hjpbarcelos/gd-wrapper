<?php
/**
 * Defines Reader interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use GdWrapper\Resource\Resource;

/**
 * Represents an input "device" to resources.
 */
interface Reader 
{
	/**
	 * Creates an image resource based on a filepath.
	 * 
	 * @param string $path The path to a valid image.
	 * @return Resource A new Resource object. 
	 * @throws \GdWrapper\Io\Exception 
	 */
	public function read($path);
}