<?php
/**
 * Defines resize strategy interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\MergeStrategy;

use GdWrapper\Action\Merge;
use GdWrapper\Resource\Resource;

class DefaultMerge implements Strategy
{
    /**
     * Wil just return the resource as it is.
     *
     * {@inherit-doc}
     * @see GdWrapper\Action\MergeStrategy.Strategy::getMergeResource()
     */
    public function getMergeResource(Merge $action, Resource $src)
    {
        return $action->getMergeResource();
    }
}