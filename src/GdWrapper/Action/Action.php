<?php
/**
 * Defines Action interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action;

use GdWrapper\Resource\Resource;

/**
 * Interface representing an action over an image.
 */
interface Action {
    /**
     * Excecutes an action over images.
     *
     * @param \GdWrapper\Resource\Resource $src The source resource for resizing.
     * 
     * @return void
     * 
     * @throws \UnexpectedValueException If something goes wrong while calculating
     * new image dimensions.
     */
    public function execute(Resource $src);
}