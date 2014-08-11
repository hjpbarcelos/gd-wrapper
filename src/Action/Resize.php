<?php
/**
 * Defines Resize operation class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action;

use Hjpbarcelos\GdWrapper\Action\ResizeMode\Mode;
use Hjpbarcelos\GdWrapper\Resource\EmptyResourceFactory;
use Hjpbarcelos\GdWrapper\Resource\Resource;

/**
 * Abstraction for resizing an image.
 */
class Resize extends AbstractAction
{
    private $mode;
    
    /**
     * {@inherit-doc}
     *
     * Creates a resize operation object.
     *
     * @param Hjpbarcelos\GdWrapper\Action\ResizeMode\Mode $mode The mode of resizing.
     *
     * @see Hjpbarcelos\GdWrapper\Action\AbstractAction::__construct()
     */
    public function __construct(Mode $mode, $resourceFactoryClass = null)
    {
        $this->mode = $mode;
        parent::__construct($resourceFactoryClass);
    }
    
    /**
     * Resizes an image based on the mode passed in the constructor.
     *
     * {@inheritdoc}
     *
     * @see Hjpbarcelos\GdWrapper\Action\Action::execute()
     */
    public function execute(Resource $src) {
        $dimensions = null;
        try {
            $dimensions = $this->mode->getNewDimensions(
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