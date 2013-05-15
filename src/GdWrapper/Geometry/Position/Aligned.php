<?php
/**
 * Defines a aligned positioning strategy.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Geometry\Position;

use GdWrapper\Geometry\Alignment\Alignment;
use GdWrapper\Geometry\Point;

/**
 * Represents an aligned positioning strategy.
 *
 */
class Aligned implements Position
{
	/**
	 * @var \GdWrapper\Geometry\Alignment\Alignment The vertical alignments
	 */
	private $vertical;
	
	/**
	 * @var \GdWrapper\Geometry\Alignment\Alignment The horizontal alignments
	 */
	private $horizontal;
	
	/**
	 * Creates an aligned position object.
	 *
	 * There are two possible signatures:
	 *
	 * * `__construct($alignment)`: Both vertical and horizontal axis will be have the same alignment.
	 * * `__construct($vertical, $horizontal)`: Each axis will have its own alignment.
	 *
	 * @param \GdWrapper\Geometry\Alignment\Alignment $horizontal
	 * @param \GdWrapper\Geometry\Alignment\Alignment $vertical
	 */
	public function __construct(Alignment $horizontal, Alignment $vertical = null)
	{
		if ($vertical === null)
		{
			$vertical = $horizontal;
		}
		
		$this->setHorizontal($horizontal);
		$this->setVertical($vertical);
	}
	
	/**
	 * Obtains the vertical alignment of the position.
	 *
	 * @return \GdWrapper\Geometry\Alignment\Alignment
	 */
	public function getVertical()
	{
	    return $this->vertical;
	}
	
	/**
	 * Sets the vertical alignment of the position.
	 *
	 * @param Alignment $vertical
	 *
	 * @return void
	 */
	public function setVertical(Alignment $vertical)
	{
	    $this->vertical = $vertical;
	}
	
	/**
	 * Obtains the horizontal alignment of the position.
	 *
	 * @return \GdWrapper\Geometry\Alignment\Alignment
	 */
	public function getHorizontal()
	{
	    return $this->horizontal;
	}
	
	/**
	 * Sets the horizontal alignment of the position.
	 *
	 * @param Alignment $horizontal
	 *
	 * @return void
	 */
	public function setHorizontal(Alignment $horizontal)
	{
	    $this->horizontal = $horizontal;
	}
	
	/**
	 * {@inherit-doc}
	 * @see GdWrapper\Geometry\Position\Position::getStartPoint()
	 */
	public function getStartPoint(Point $outsideDimensions, Point $insideDimensions)
	{
		return new Point(
				$this->horizontal->getPosition(
					$outsideDimensions->getX(),
					$insideDimensions->getX()
				),
				$this->vertical->getPosition(
					$outsideDimensions->getY(),
					$insideDimensions->getY()
				)
		);
	}
}