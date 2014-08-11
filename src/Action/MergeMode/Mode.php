<?php
/**
 * Defines resize mode interface.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action\MergeMode;

use Hjpbarcelos\GdWrapper\Action\Merge;
use Hjpbarcelos\GdWrapper\Resource\Resource;

interface Mode
{
    /**
     * Obtains the merge resource to be used in the merging action.
     *
     * @param Hjpbarcelos\GdWrapper\Action\Merge $action The action that will be performed.
     * @param Hjpbarcelos\GdWrapper\Resource\Resource $src The image resource on which the action will be applied.
     *
     * @return Hjpbarcelos\GdWrapper\Resource\Resource The merge resource.
     */
    public function getMergeResource(Merge $action, Hjpbarcelos\GdWrapper\Resource\Resource $src);
}
