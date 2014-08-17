<?php
/**
 * Defines AbstractAlignment class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Alignment;

use Hjpbarcelos\GdWrapper\Geometry\Padding\Padding;

/**
 * Common aspects of a Alignment class.
 */
abstract class AbstractAlignment implements Alignment
{
	/**
	 * @var Padding Keeps a padding for calculating the distance from the original Alignment.
	 */
	private $padding;
	
	/**
	 * @param Padding $padding [OPTIONAL] This parameter should be provided if you want
	 * 		that the alignment to have a padding form the reference Alignment.
	 */
	public function __construct(Padding $padding = null)
	{
		if ($padding !== null) {
			$this->setPadding($padding);
		}
	}
	
	/**
	 * Sets a padding for the alignment.
	 *
	 * @param Padding $padding
	 *
	 * @return void
	 */
	public function setPadding(Padding $padding)
	{
		$this->padding = $padding;
	}
	
	/**
	 * Obtains the alignment padding
	 *
	 * @return int
	 */
	public function getPadding()
	{
		return $this->padding;
	}
	
	/**
	 * Obtains the integer value for the padding, or `0` if ther is none.
	 *
	 * @param int $refDimension
	 * @return int
	 */
	protected function getPaddingValue($refDimension)
	{
		return $this->getPadding() === null ? 0 : $this->getPadding()->getDistance($refDimension);
	}
}