<?php
/**
 * Defines AbstractIo class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Writer;

use GdWrapper\Resource\Resource;

/**
 * Defines an abstract implementation of a I/O device for resources.
 */
abstract class AbstractWriter implements Writer
{
	/**
	 * @var Resource The Resource object this object will work on.
	 */
	private $resource;
	
	/**
	 * Creates a new output "device".
	 * 
	 * @param \GdWrapper\Resource\Resource $resource An image resource.
	 */
	public function __construct(Resource $resource)
	{
		$this->setResource($resource);
	}
	
	/**
	 * {@inheritdoc}
	 * 
	 * @see GdWrapper\Io\Writer::getResource()
	 */
	public function getResource()
	{
		return $this->resource;
	}
	
	/**
	 * {@inheritdoc}
	 * 
	 * @see GdWrapper\Io\Writer::setResource()
	 */
	public function setResource(Resource $resource)
	{
		$this->resource = $resource;
	}
}