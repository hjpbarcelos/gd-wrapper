<?php
/**
 * Defines a crop strategy with fixed size edges.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\CropStrategy;

use GdWrapper\Geometry\Point;
use GdWrapper\Geometry\Margin\Margin;

/**
 * This crop strategy crops from the egdes of the file with the margin parameters.
 */
class FromEdges implements Strategy
{
    /**
     * @var \GdWrapper\Geometry\Margin\Margin The distance from the top edge.
     */
    private $top;
    
    /**
     * @var \GdWrapper\Geometry\Margin\Margin The distance from the right edge.
     */
    private $right;
    
    /**
     * @var \GdWrapper\Geometry\Margin\Margin The distance from the bottom edge.
     */
    private $bottom;
    
    /**
     * @var \GdWrapper\Geometry\Margin\Margin  The distance from the left edge.
     */
    private $left;

    /**
     * Creates a FixedEgdes cropping strategy.
     *
     * The 4 parameters of the constructor represents the distance of cropping
     * for each edge of the image.
     *
     * NOTE: negative values will crop out from the original images, creating a black border
     * around the image.
     *
     * There are 4 possible signatures for this constructor:
     * * `__construct($top, $right, $bottom, $left)`: Each edge is separately provided.
     * * `__construct($top, $right, $bottom)`: `$left` will have the same value of `$right`.
     * * `__construct($top, $right)`: `$bottom` and `$left` will have the same value of
     *     `$top` and `$right` respectively.
     * * `__construct($top)`: All cropping edges will have the same distance from the
     *     original image edges.
     *
     * @param \GdWrapper\Geometry\Margin\Margin $top The distance from the top edge.
     * @param \GdWrapper\Geometry\Margin\Margin $right [OPTIONAL] The distance from the right edge.
     * @param \GdWrapper\Geometry\Margin\Margin $bottom [OPTIONAL] The distance from the bottom edge.
     * @param \GdWrapper\Geometry\Margin\Margin $left [OPTIONAL] The distance from the left edge.
     */
    public function __construct(Margin $top, Margin $right = null, Margin $bottom = null, Margin $left = null)
    {
        if ($right === null) {
            $this->setup($top, $top, $top, $top);
        } else if ($bottom === null) {
            $this->setup($top, $right, $top, $right);
        } else if ($left === null) {
            $this->setup($top, $right, $bottom, $right);
        } else {
            $this->setup($top, $right, $bottom, $left);
        }
    }
    
    /**
     * Setups edges.
     *
     * @param \GdWrapper\Geometry\Margin\Margin $top The distance from the top edge.
     * @param \GdWrapper\Geometry\Margin\Margin $right The distance from the right edge.
     * @param \GdWrapper\Geometry\Margin\Margin $bottom The distance from the bottom edge.
     * @param \GdWrapper\Geometry\Margin\Margin $left The distance from the left edge.
     */
    private function setup(Margin $top, Margin $right, Margin $bottom, Margin $left)
    {
        $this->top = $top;
        $this->right = $right;
        $this->bottom = $bottom;
        $this->left = $left;
    }

    /**
     * (non-PHPdoc)
     * @see GdWrapper\Action\CropStrategy\Strategy::getCropInfo()
     */
    public function getCropInfo($width, $height)
    {
        return new CropInfo(
            new Point(
                $this->left->getDistance($width), $this->top->getDistance($height)
            ),
            (int) ($width - $this->right->getDistance($width) - $this->left->getDistance($width)),
            (int) ($height - $this->bottom->getDistance($height) - $this->top->getDistance($height))
        );
    }
}