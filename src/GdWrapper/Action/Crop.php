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

class Crop implements Action
{
    /**
     * @var \GdWrapper\Action\CropStrategy\Strategy The cropping strategy
     */
    private $strategy;
    
    /**
     * Creates a Crop action.
     * 
     * @param Strategy $strategy The cropping strategy.
     */
    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }
    
    /**
     * (non-PHPdoc)
     * @see GdWrapper\Action\Action::execute()
     */
    public function execute(Resource $src)
    {
        $info = $this->strategy->getCropInfo($src->getWidth(), $src->getHeight());
        
        $factory = new EmptyResourceFactory(
            $info['width'],
            $info['height']
        );
        
        $dst = $factory->create();
        
        imagecopyresampled(
            $dst->getRaw(), $src->getRaw(),
            0, 0, $info['start_x'], $info['start_y'],
            $dst->getWidth(), $dst->getHeight(),
            $dst->getWidth(), $dst->getHeight()
        );
        
        $src->setRaw($dst->getRaw());
    }
}