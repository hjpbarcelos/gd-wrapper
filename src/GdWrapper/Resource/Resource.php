<?php
/**
 * Defines Resource interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

/**
 * Wrapper for GD2 image resource type.
 */
interface Resource
{
    /**
     * Obtains the raw GD2 image resource of this wrapper object.
     *
     * @return resource A valid GD2 image resource.
     */
    public function getRaw();
    
    /**
     * Get image width.
     *
     * @return int The image width
     */
    public function getWidth();
    
    /**
     * Get image height.
     *
     * @return int The image height
     */
    public function getHeight();
}