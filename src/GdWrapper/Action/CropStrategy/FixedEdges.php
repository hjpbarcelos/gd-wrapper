<?php
/**
 * Defines a crop strategy with fixed size edges.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\CropStrategy;

/**
 * This crop strategy crops from the egdes of the file by a fixed number of pixels. 
 */
class FixedEdges implements Strategy
{
    /**
     * @var int The distance from the top edge.
     */
    private $top;
    
    /**
     * @var int The distance from the right edge.
     */
    private $right;
    
    /**
     * @var int The distance from the bottom edge.
     */
    private $bottom;
    
    /**
     * @var int The distance from the left edge.
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
     * * * `__construct($top, $right, $bottom)`: `$left` will have the same value of `$right`.
     * * `__construct($top, $right)`: `$bottom` and `$left` will have the same value of
     *     `$top` and `$right` respectively.
     * * `__construct($top)`: All cropping edges will have the same distance from the
     *     original image edges. 
     * 
     * @param int $top The distance from the top edge. 
     * @param int $right [OPTIONAL] The distance from the right edge.
     * @param int $bottom [OPTIONAL] The distance from the bottom edge.
     * @param int $left [OPTIONAL] The distance from the left edge.
     */
    public function __construct($top, $right = null, $bottom = null, $left = null)
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
     * @param int $top The distance from the top edge. 
     * @param int $right The distance from the right edge.
     * @param int $bottom The distance from the bottom edge.
     * @param int $left The distance from the left edge.
     */
    private function setup($top, $right, $bottom, $left)
    {
        $this->top = (int) $top;
        $this->right = (int) $right;
        $this->bottom = (int) $bottom;
        $this->left = (int) $left;
    }

    /**
     * (non-PHPdoc)
     * @see GdWrapper\Action\CropStrategy\Strategy::getCropInfo()
     */
    public function getCropInfo($width, $height)
    {
        return array(
            'start_x' => $this->left,
            'start_y' => $this->top,
            'width' => (int) ($width - $this->right - $this->left),
            'height' => (int) ($height - $this->bottom - $this->top),
        );
    }
}