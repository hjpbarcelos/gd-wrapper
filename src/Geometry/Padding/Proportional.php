<?php
/**
 * Defines a fixed padding implementation.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Padding;

/**
 * Proportinal padding is calculated based on a proportion of the base dimension.
 */
class Proportional implements Padding {
	/**
	 * @var float The proportion of the padding
	 */
	private $proportion;

	/**
	 * Creates a proportional padding object.
	 * 
	 * @param float $proportion The proportion of the padding that will be calculated.
	 */
	public function __construct($proportion)
	{
		$this->setProportion($proportion);
	}
	
	/**
	 * Sets the proportion of the padding.
	 * 
	 * @param float $proportion The proportion of the padding that will be calculated.
	 * 
	 * @return void
	 */
	public function setProportion($proportion)
	{
		$this->proportion = (float) $proportion;
	}
	
	/**
	 * Proportinal padding is calculated based on a proportion of the base dimension.
	 *
	 * {@inherit-doc}
	 *
	 * @see Hjpbarcelos\GdWrapper\Geometry\Padding\Padding::getDistance()
	 */
	public function getDistance($refDimension)
	{
		return round($this->proportion * $refDimension);
	}
}