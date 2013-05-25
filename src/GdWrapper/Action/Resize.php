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
 * Abstraction for resizing an image.
 */
class Resize extends AbstractAction
{
    private $strategy;
    
    /**
     * {@inherit-doc}
     *
     * Creates a resize operation object.
     *
     * @param \GdWrapper\Action\ResizeStrategy\Strategy $strategy The strategy of resizing.
     *
     * @see \GdWrapper\Action\AbstractAction::__construct()
     */
    public function __construct(Strategy $strategy, $resourceFactoryClass = null)
    {
        $this->strategy = $strategy;
        parent::__construct($resourceFactoryClass);
    }
    
    /**
     * Resizes an image based on the strategy passed in the constructor.
     *
     * {@inheritdoc}
     *
     * @see GdWrapper\Action\Action::execute()
     */
    public function execute(Resource $src) {
        $dimensions = null;
        try {
            $dimensions = $this->strategy->getNewDimensions(
                $src->getWidth(),
                $src->getHeight()
            );
        } catch (\InvalidArgumentException $e) {
            throw new \UnexpectedValueException(
                'The image seems to have no size at all.', $e->getCode(), $e
            );
        }

        $factory = $this->getResourceFactory(
            $dimensions->getX(),
            $dimensions->getY()
        );
        
        $dst = $factory->create();
        
        imagecopyresampled(
            $dst->getRaw(), $src->getRaw(),
            0, 0, 0, 0,
            $dst->getWidth(), $dst->getHeight(),
            $src->getWidth(), $src->getHeight()
        );
        
        $src->setRaw($dst->getRaw());
    }
}