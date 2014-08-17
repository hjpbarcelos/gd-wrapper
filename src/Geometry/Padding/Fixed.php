<?php
/**
 * Defines a fixed padding implementation.
 *  
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Padding;

/**
 * Fixed padding independ from the reference dimension.
 * This class will always obtain a fixed value for paddings. 
 */
class Fixed implements Padding
{
	/**
	 * @var int The padding distance represented by this object.
	 */
	private $distance;
	
	/**
	 * Creates a fixed padding object.
	 * 
	 * @param int $distance The fixed distance from the limits that will be used.
	 */
	public function __construct($distance)
	{
		$this->setDistance($distance);
	}
	
	/**
	 * Sets the padding distance for the object.
	 *
	 * @param int $distance The fixed distance from the limits that will be used.
	 * 
	 * @return void
	 */
	public function setDistance($distance)
	{
		$this->distance = (int) $distance;
	}
	
	/**
	 * Fixed padding independ from the reference dimension.
 	 * This method will always obtain a fixed value for paddings.
 	 *  
	 * {@inherit-doc}
	 * 
	 * @see Hjpbarcelos\GdWrapper\Geometry\Padding\Padding::getDistance()
	 */
	public function getDistance($refDimension)
	{
		return $this->distance;
	}
} 