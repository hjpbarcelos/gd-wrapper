<?php
/**
 * Defines ImageInfo class.
 *
 * @author Henrique Barcelos
 */

namespace GdWrapper\Image;

/**
 * Holds information about an image on file system.
 */
class Info extends \SplFileInfo
{
    /**
     * @var int The image width
     */
    private $width = 0;

    /**
     * @var int The image height
     */
    private $height = 0;

    /**
     * Get image width.
     *
     * @return int The image width.
     *
     * @throws \RuntimeException If somehow this method fails in obtaining
     *     the width and the height of the image. This may happen because
     *     this object does not point to a valid file, the file pointed by
     *     this object is unreadable or `getimagesize` function call fails.
     */
    public function getWidth()
    {
        if ($this->width == 0) {
            $this->loadInfo();
        }
        return $this->width;
    }

    /**
     * Get image height.
     *
     * @return int The image height.
     *
     * @throws \RuntimeException If somehow this method fails in obtaining
     *     the width and the height of the image. This may happen because
     *     this object does not point to a valid file, the file pointed by
     *     this object is unreadable or `getimagesize` function call fails.
     */
    public function getHeight()
    {
        if ($this->height == 0) {
            $this->loadInfo();
        }
        return $this->height;
    }
    
    /**
     * Loads info of a file.
     *
     * @throws \RuntimeException If somehow this method fails in obtaining
     *     the width and the height of the image. This may happen because
     *     this object does not point to a valid file, the file pointed by
     *     this object is unreadable or `getimagesize` function call fails.
     */
    private function loadInfo() {
        if (!$this->isFile()) {
            throw new \RuntimeException(
                "Path '{$this->getPathname()}' does not point to a valid file"
            );
        }
        
        if (!$this->isReadable()) {
            throw new \RuntimeException(
                "File '{$this->getPathname()}' is unreadable"
            );
        }
        
        $info = getimagesize($this->getPathname());
        if (!is_array($info)) {
            throw new \RuntimeException(
                "Error on acquiring information about file '{$this->getPathname()}'"
            );
        }
        
        $this->width = $info[0];
        $this->height = $info[1];
    }
}
