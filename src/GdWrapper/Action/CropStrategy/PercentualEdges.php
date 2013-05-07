<?php
/**
 * Defines a crop strategy with proportional size edges.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\CropStrategy;

/**
 * This crop strategy crops from the egdes of the file by a fixed number of pixels. 
 */
class PercentualEdges implements Strategy
{
    /**
     * @var float The proportional distance from the top edge.
     */
    private $top;
    
    /**
     * @var float The proportional distance from the right edge.
     */
    private $right;
    
    /**
     * @var float The proportional distance from the bottom edge.
     */
    private $bottom;
    
    /**
     * @var float The proportional distance from the left edge.
     */
    private $left;

    /**
     * Creates a percentual cropping strategy.
     * 
     * IMPORTANT: the sum of parameters that concerns to the same axis (X or Y) MUST 
     * be less than 1 (1 means 100%). Otherwise, it would result in an image without
     * width or height.
     * 
     * NOTE: negative values will crop out from the original images, creating a black border
     * around the image.
     * 
     * The 4 parameters of the constructor represents the proportional distance of cropping
     * for each edge of the image.
     * 
     * There are 4 possible signatures for this constructor:
     * * `__construct($top, $right, $bottom, $left)`: Each edge is separately provided.
     * * * `__construct($top, $right, $bottom)`: `$left` will have the same value of `$right`.
     * * `__construct($top, $right)`: `$bottom` and `$left` will have the same value of
     *     `$top` and `$right` respectively.
     * * `__construct($top)`: All cropping edges will have the same distance from the
     *     original image edges. 
     * 
     * @param float $top The proportional distance from the top edge. 
     * @param float $right [OPTIONAL] The proportional distance from the right edge.
     * @param float $bottom [OPTIONAL] The proportional distance from the bottom edge.
     * @param float $left [OPTIONAL] The proportional distance from the left edge.
     * 
     * @throws \RangeException If some parameter has a invalid value.
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
     * @param float $top The proportional distance from the top edge. 
     * @param float $right The proportional distance from the right edge.
     * @param float $bottom The proportional distance from the bottom edge.
     * @param float $left The proportional distance from the left edge.
     * 
     * @throws \RangeException If some parameter has a invalid value.
     */
    private function setup($top, $right, $bottom, $left)
    {
        if ($top + $bottom >= 1) {
            throw new \RangeException(
                "Proportional edges of values [{$top}, {$bottom}] would result on an image with no height."
            );
        }
        
        if ($left + $right >= 1) {
            throw new \RangeException(
                "Proportional edges of values [{$top}, {$bottom}] would result on an image with no width."
            );
        }
        
        $this->top = (float) $top;
        $this->right = (float) $right;
        $this->bottom = (float) $bottom;
        $this->left = (float) $left;
    }

    /**
     * (non-PHPdoc)
     * @see GdWrapper\Action\CropStrategy\Strategy::getCropInfo()
     */
    public function getCropInfo($width, $height)
    {
        $startX = round($this->left * $width);
        $startY = round($this->top * $height);
        $endX = round($this->right * $width);
        $endY = round($this->top * $height);
        return array(
            'start_x' => $startX,
            'start_y' => $startY,
            'width' => round($width - $startX - $endX),
            'height' => round($height - $startY - $endY),
        );
    }
}