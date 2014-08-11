<?php
/**
 * Defines resize mode interface.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action\MergeMode;

use Hjpbarcelos\GdWrapper\Action\Merge;
use Hjpbarcelos\GdWrapper\Resource\Resource;

class DefaultMerge implements Mode
{
    /**
     * Wil just return the resource as it is.
     *
     * {@inherit-doc}
     * @see Hjpbarcelos\GdWrapper\Action\MergeMode.Mode::getMergeResource()
     */
    public function getMergeResource(Merge $action, Resource $src)
    {
        return $action->getMergeResource();
    }
}