<?php
/**
 * Defines Crop operation class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action;

use GdWrapper\Action\CropStrategy\Strategy;
use GdWrapper\Resource\Resource;
use GdWrapper\Resource\EmptyResourceFactory;

/**
 * Abstraction for cropping an image.
 */
class Crop extends AbstractAction
{
    /**
     * @var \GdWrapper\Action\CropStrategy\Strategy The cropping strategy
     */
    private $strategy;
    
    /**
     * {@inherit-doc}
     *
     * Creates a Crop action.
     *
     * @param Strategy $strategy The cropping strategy.
     *
     * @see \GdWrapper\Action\AbstractAction::__construct()
     */
    public function __construct(Strategy $strategy, $resourceFactoryClass = null)
    {
        $this->strategy = $strategy;
        parent::__construct($resourceFactoryClass);
    }
    
    /**
     * (non-PHPdoc)
     * @see GdWrapper\Action\Action::execute()
     */
    public function execute(Resource $src)
    {
        $info = $this->strategy->getCropInfo($src->getWidth(), $src->getHeight());
        
        $factory = $this->getResourceFactory(
            $info->getWidth(),
            $info->getHeight()
        );
        
        $dst = $factory->create();
        
        imagecopyresampled(
            $dst->getRaw(), $src->getRaw(),
            0, 0,
            $info->getStartPoint()->getX(), $info->getStartPoint()->getY(),
            $dst->getWidth(), $dst->getHeight(),
            $dst->getWidth(), $dst->getHeight()
        );
        
        $src->setRaw($dst->getRaw());
    }
}