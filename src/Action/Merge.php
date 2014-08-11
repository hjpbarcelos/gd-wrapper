<?php
/**
 * Defines Merge operation class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action;

use Hjpbarcelos\GdWrapper\Action\MergeMode\Mode;
use Hjpbarcelos\GdWrapper\Action\MergeMode\DefaultMerge;
use Hjpbarcelos\GdWrapper\Geometry\Point;
use Hjpbarcelos\GdWrapper\Geometry\Position\Position;
use Hjpbarcelos\GdWrapper\Resource\Resource;

/**
 * Abstraction for cropping an image.
 */
class Merge extends AbstractAction
{
    /**
     * @var Hjpbarcelos\GdWrapper\Resource\Resource The image that will be merged into another images.
     */
    private $mergeResource;
    
    /**
     * @var Hjpbarcelos\GdWrapper\Geometry\Position\Position The position where the merge resource will be placed.
     */
    private $position;
    
    /**
     * @var int The opacity of merging, from 0 to 100.
     */
    private $opacity;
    
    /**
     * @var Hjpbarcelos\GdWrapper\Action\MergeMode\Mode The merging mode.
     */
    private $mode;
    
    /**
     * {@inherit-doc}
     *
     * Creates a new Merge action.
     *
     * The parameter `$opacity` must be an integer from `0` to `100`, where `0` means completely
     * transparent merging (that is, no visible modifications) and `100` means opaque merging,
     * with all the pixels of the merge resource overlaping the original one in the merge area.
     *
     * @param Hjpbarcelos\GdWrapper\Resource\Resource $merge The image resource that will be merged into another images.
     * @param Hjpbarcelos\GdWrapper\Geometry\Position\Position $position The position where the merge resource will be placed.
     * @param int $opacity [OPTIONAL] The opacity of the merged image.
     * @param Hjpbarcelos\GdWrapper\Action\MergeMode\Mode $mode [OPTIONAL] The merging mode.
     *
     * @see Hjpbarcelos\GdWrapper\Action\AbstractAction::__construct()
     */
    public function __construct(Resource $merge, Position $position, $opacity = 100, Mode $mode = null, $resourceFactoryClass = null)
    {
        $this->setMergeResource($merge);
        $this->setPosition($position);
        $this->setOpacity($opacity);
        
        if ($mode === null) {
            $mode = new DefaultMerge();
        }
        
        $this->setMode($mode);
        parent::__construct($resourceFactoryClass);
    }

    /**
     * Obtains the merge resource of this action.
     *
     * @return Hjpbarcelos\GdWrapper\Resource\Resource The merge resource.
     */
    public function getMergeResource()
    {
        return $this->mergeResource;
    }

    /**
     * Sets the merge resource of this action.
     *
     * @param Resource $mergeResource The merge resource.
     */
    public function setMergeResource(Resource $mergeResource)
    {
        $this->mergeResource = $mergeResource;
    }

    /**
     * Obtains the position of merging of this action.
     *
     * @return Hjpbarcelos\GdWrapper\Geometry\Position\Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the merge position of this action.
     *
     * @param Hjpbarcelos\GdWrapper\Geometry\Position\Position $position The position.
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;
    }

    /**
     * Obtains the opacity of merging of this action.
     *
     * @return int
     */
    public function getOpacity()
    {
        return $this->opacity;
    }

    /**
     * Sets the opacity of merging of this action.
     *
     * The parameter `$opacity` must be an integer from `0` to `100`, where `0` means completely
     * transparent merging (that is, no visible modifications) and `100` means opaque merging,
     * with all the pixels of the merge resource overlaping the original one in the merge area.
     *
     * @param int $opacity The opacity of merging.
     *
     * @throws \RangeException If `$opacity` is not between `0` and `100`.
     */
    public function setOpacity($opacity)
    {
        $opacity = (int) $opacity;
        
        if($opacity < 0 || $opacity > 100) {
            throw new \RangeException("Opacity value must be between 0 and 100, {$opacity} given");
        }
        
        $this->opacity = $opacity;
    }
    
    /**
     * Shortcut for obtaining the start point of the position for the merged image.
     *
     * @param Hjpbarcelos\GdWrapper\Action\MergeMode\Mode $mode The merge mode.
     *
     * @return Hjpbarcelos\GdWrapper\Geometry\Point The starting point of the position for the merged image.
     */
    public function getStartPoint(Resource $src)
    {
        return $this->position->getStartPoint(
            new Point($src->getWidth(), $src->getHeight()),
            new Point(
                $this->mergeResource->getWidth(),
                $this->mergeResource->getHeight()
            )
        );
    }
    
    /**
     * Obtains the merge mode.
     *
     * @return Hjpbarcelos\GdWrapper\Action\MergeMode\Mode
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Sets the merge mode.
     *
     * @param Hjpbarcelos\GdWrapper\Action\MergeMode\Mode $mode The merge mode.
     */
    public function setMode(Mode $mode)
    {
        $this->mode = $mode;
    }
    
    /**
     * {@inherit-doc}
     * @see Hjpbarcelos\GdWrapper\Action\Action::execute()
     */
    public function execute(Resource $src)
    {
        $startPoint = $this->getStartPoint($src);
        /* Important: PHP garbage collector does not seems to count a function
         * parameter as a reference to an object, so, if you call a function using
         * a returned object without assigning it to a variable, the destructor of
         * the object will be called!
         */
        $merge = $this->mode->getMergeResource($this, $src);
        
        imagecopymerge(
            $src->getRaw(), $merge->getRaw(),
            $startPoint->getX(), $startPoint->getY(), 0, 0,
            $this->mergeResource->getWidth(), $this->mergeResource->getHeight(),
            $this->opacity
        );
    }
}