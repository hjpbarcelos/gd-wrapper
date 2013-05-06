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
    private $strategy;
    
    /**
     * Creates a resize operation object.
     *
     * @param \GdWrapper\Action\ResizeStrategy\Strategy $strategy The strategy of resizing.
     */
    public function __construct(
        Strategy $strategy)
    {
        $this->strategy = $strategy;
    }
    
    /**
     * Resizes an image based on the strategy passed in the constructor.
     *
     * {@inheritdoc}
     *
     * @see GdWrapper\Action.Action::execute()
     */
    public function execute(Resource $resource) {
        try {
            $dimensions = $this->strategy->getNewDimensions(
                $resource->getWidth(),
                $resource->getHeight()
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
            $dst->getRaw(), $resource->getRaw(),
            0, 0, 0, 0,
            $dst->getWidth(), $dst->getHeight(),
            $resource->getWidth(), $resource->getHeight()
        );
        
        return $dst;
    }
}