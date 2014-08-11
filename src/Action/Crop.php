<?php
/**
 * Defines Crop operation class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action;

use Hjpbarcelos\GdWrapper\Action\CropMode\Mode;
use Hjpbarcelos\GdWrapper\Resource\Resource;
use Hjpbarcelos\GdWrapper\Resource\EmptyResourceFactory;

/**
 * Abstraction for cropping an image.
 */
class Crop extends AbstractAction
{
    /**
     * @var Hjpbarcelos\GdWrapper\Action\CropMode\Mode The cropping mode
     */
    private $mode;
    
    /**
     * {@inherit-doc}
     *
     * Creates a Crop action.
     *
     * @param Mode $mode The cropping mode.
     *
     * @see Hjpbarcelos\GdWrapper\Action\AbstractAction::__construct()
     */
    public function __construct(Mode $mode, $resourceFactoryClass = null)
    {
        $this->mode = $mode;
        parent::__construct($resourceFactoryClass);
    }
    
    /**
     * (non-PHPdoc)
     * @see Hjpbarcelos\GdWrapper\Action\Action::execute()
     */
    public function execute(Resource $src)
    {
        $info = $this->mode->getCropInfo($src->getWidth(), $src->getHeight());
        
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