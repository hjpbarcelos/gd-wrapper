<?php
/**
 * Defines a fixed margin implementation.
 *  
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Margin;

/**
 * Fixed margin independ from the reference dimension.
 * This class will always obtain a fixed value for margins. 
 */
class Fixed implements Margin
{
	/**
	 * @var int The margin distance represented by this object.
	 */
	private $distance;
	
	/**
	 * Creates a fixed margin object.
	 * 
	 * @param int $distance The fixed distance from the limits that will be used.
	 */
	public function __construct($distance)
	{
		$this->setDistance($distance);
	}
	
	/**
	 * Sets the margin distance for the object.
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
	 * Fixed margin independ from the reference dimension.
 	 * This method will always obtain a fixed value for margins.
 	 *  
	 * {@inherit-doc}
	 * 
	 * @see Hjpbarcelos\GdWrapper\Geometry\Margin\Margin::getDistance()
	 */
	public function getDistance($refDimension)
	{
		return $this->distance;
	}
} 