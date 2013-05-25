<?php
/**
 * Defines resize strategy interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\MergeStrategy;

use GdWrapper\Action\Merge;
use GdWrapper\Resource\Resource;

interface Strategy
{
    /**
     * Obtains the merge resource to be used in the merging action.
     *
     * @param Merge $action The action that will be performed.
     * @param Resource $src The image resource on which the action will be applied.
     *
     * @return \GdWrapper\Resource\Resource The merge resource.
     */
    public function getMergeResource(Merge $action, Resource $src);
}