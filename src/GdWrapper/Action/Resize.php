<?php
/**
 * Defines Action interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action;

use GdWrapper\Action\ResizeStrategy\Exact;
use GdWrapper\Action\ResizeStrategy\Strategy;
use GdWrapper\Resource\EmptyResourceFactory;
use GdWrapper\Resource\Resource;

class Resize implements Action
{
    private $resource;
    private $strategy;
    
    public function __construct(
        Resource $src,
        Strategy $strategy)
    {
        $this->resource = $src;
        $this->strategy = $strategy;
    }
    
    public function execute() {
        $dimensions = $this->strategy->getNewDimensions(
            $this->resource->getWidth(),
            $this->resource->getHeight()
        );
        
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