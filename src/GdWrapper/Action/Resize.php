<?php
/**
 * Defines Resize operation class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action;

use GdWrapper\Action\ResizeStrategy\Strategy;
use GdWrapper\Resource\EmptyResourceFactory;
use GdWrapper\Resource\Resource;

/**
 * Resizes an image.
 */
class Resize implements Action
{
    private $resource;
    private $strategy;
    
    /**
     * Creates a resize operation object.
     *
     * @param \GdWrapper\Resource\Resource $src The source resource for resizing.
     * @param \GdWrapper\Action\ResizeStrategy\Strategy $strategy The strategy of resizing.
     */
    public function __construct(
        Resource $src,
        Strategy $strategy)
    {
        $this->resource = $src;
        $this->strategy = $strategy;
    }
    
    /**
     * Resizes an image based on the strategy passed in the constructor.
     *
     * {@inheritdoc}
     *
     * @see GdWrapper\Action.Action::execute()
     */
    public function execute() {
        try {
            $dimensions = $this->strategy->getNewDimensions(
                $this->resource->getWidth(),
                $this->resource->getHeight()
            );
        } catch (\InvalidArgumentException $e) {
            throw new \UnexpectedValueException(
                'The image seems to have no size at all.', $e->getCode(), $e
            );
        }

        $factory = new EmptyResourceFactory(
            $dimensions['width'],
            $dimensions['height']
        );
        
        $dst = $factory->create();
        
        imagecopyresampled(
            $dst->getRaw(), $this->resource->getRaw(),
            0, 0, 0, 0,
            $dst->getWidth(), $dst->getHeight(),
            $this->resource->getWidth(), $this->resource->getHeight()
        );
        
        return $dst;
    }
}