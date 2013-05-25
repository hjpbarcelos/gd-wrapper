<?php
/**
 * Defines resize strategy interface.
 *
 * @author Henrique Barcelos
 */

namespace GdWrapper\Action\MergeStrategy;

use GdWrapper\Action\Merge;
use GdWrapper\Resource\Resource;
use GdWrapper\Resource\TransparentResourceFactory;

class SaveAlphaChannel implements Strategy
{
    /**
     * Wil just return the resource as it is.
     *
     * {@inherit-doc}
     * @see GdWrapper\Action\MergeStrategy\Strategy::getMergeResource()
     */
    public function getMergeResource(Merge $action, Resource $src)
    {
        $mergeResource = $action->getMergeResource();
        $startPoint = $action->getStartPoint($src);
        
        $factory = $action->getResourceFactory($mergeResource->getWidth(), $mergeResource->getHeight());
        $cut = $factory->create();
        
        imagecopy(
            $cut->getRaw(), $src->getRaw(),
            0, 0, $startPoint->getX(), $startPoint->getY(),
            $cut->getWidth(), $cut->getHeight()
        );
        
        imagealphablending($cut->getRaw(), true);
        
        imagecopy(
            $cut->getRaw(), $mergeResource->getRaw(),
            0, 0, 0, 0,
            $cut->getWidth(), $cut->getHeight()
        );
        
        return $cut;
    }
}