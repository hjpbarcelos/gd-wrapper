<?php
/**
 * Defines a fixed margin implementation.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Margin;

/**
 * Proportinal margin is calculated based on a proportion of the base dimension.
 */
class Proportional implements Margin {
	/**
	 * @var float The proportion of the margin
	 */
	private $proportion;

	/**
	 * Creates a proportional margin object.
	 * 
	 * @param float $proportion The proportion of the margin that will be calculated.
	 */
	public function __construct($proportion)
	{
		$this->setProportion($proportion);
	}
	
	/**
	 * Sets the proportion of the margin.
	 * 
	 * @param float $proportion The proportion of the margin that will be calculated.
	 * 
	 * @return void
	 */
	public function setProportion($proportion)
	{
		$this->proportion = (float) $proportion;
	}
	
	/**
	 * Proportinal margin is calculated based on a proportion of the base dimension.
	 *
	 * {@inherit-doc}
	 *
	 * @see Hjpbarcelos\GdWrapper\Geometry\Margin\Margin::getDistance()
	 */
	public function getDistance($refDimension)
	{
		return round($this->proportion * $refDimension);
	}
}