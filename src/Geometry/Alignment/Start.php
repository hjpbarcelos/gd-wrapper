<?php
/**
 * Defines a start alignment class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Alignment;

use Hjpbarcelos\GdWrapper\Geometry\Margin\Margin;

/**
 * Positions the inner segment at the beginning of the outer segment.
 *
 * A positive margin value will move the alignment to the right.
 *
 * For example:
 * <code>
 * $align = new Start(new Margin\Fixed(10));
 * $align->getPosition(100, 40); // Will return 10
 * </code>
 */
class Start extends AbstractAlignment
{
	/**
	 * Will return `0` plus the value of the margin.
	 *
	 * {@inherit-doc}
	 * @see Hjpbarcelos\GdWrapper\Geometry\Alignment\Alignment::getPosition()
	 */
	public function getPosition($outsideDimension, $insideDimension)
	{
		return $this->getMarginValue($outsideDimension);
	}
}