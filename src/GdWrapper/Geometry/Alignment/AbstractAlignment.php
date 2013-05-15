<?php
/**
 * Defines AbstractAlignment class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Geometry\Alignment;

use GdWrapper\Geometry\Margin\Margin;

/**
 * Common aspects of a Alignment class.
 */
abstract class AbstractAlignment implements Alignment
{
	/**
	 * @var Margin Keeps a margin for calculating the distance from the original Alignment.
	 */
	private $margin;
	
	/**
	 * @param Margin $margin [OPTIONAL] This parameter should be provided if you want
	 * 		that the alignment to have a margin form the reference Alignment.
	 */
	public function __construct(Margin $margin = null)
	{
		if ($margin !== null) {
			$this->setMargin($margin);
		}
	}
	
	/**
	 * Sets a margin for the alignment.
	 *
	 * @param Margin $margin
	 *
	 * @return void
	 */
	public function setMargin(Margin $margin)
	{
		$this->margin = $margin;
	}
	
	/**
	 * Obtains the alignment margin
	 *
	 * @return int
	 */
	public function getMargin()
	{
		return $this->margin;
	}
	
	/**
	 * Obtains the integer value for the margin, or `0` if ther is none.
	 *
	 * @param int $refDimension
	 * @return int
	 */
	protected function getMarginValue($refDimension)
	{
		return $this->getMargin() === null ? 0 : $this->getMargin()->getDistance($refDimension);
	}
}