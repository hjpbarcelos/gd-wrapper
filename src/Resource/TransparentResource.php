<?php
/**
 * Defines TransparentResource class.
 *
 * @author Henrique Barcelos
 */

namespace Hjpbarcelos\GdWrapper\Resource;

/**
 * Defines a transparent true color image resource.
 */
class TransparentResource extends EmptyResource {
    /**
     * {@inherit-doc}
     * @see Hjpbarcelos\GdWrapper\Resource\EmptyResource::createRaw()
     */
    protected function createRaw($width, $height) {
        $raw = imagecreatetruecolor($width, $height);
        
        
        $transparent = imagecolorallocatealpha($raw, 255, 255, 255, 127);
        imagefilledrectangle($raw, 0, 0, $width, $height, $transparent);
        return $raw;
    }
}