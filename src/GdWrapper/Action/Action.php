<?php
/**
 * Defines Action interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action;

/**
 * Interface representing an action over an image.
 */
interface Action {
    /**
     * Excecutes an action over images.
     *
     * @return void
     */
    public function execute();
}