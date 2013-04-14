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
class Info extends \SplFileInfo {
	/**
	 * @var int The image width
	 */
	private $width = null;
	
	/**
	 * @var int The image height
	 */
	private $height = null;
	
	/**
	 * Get image width.
	 *
	 * @return int The image width
	 */
	public function getWidth() {
		if($this->width === null) {
			$info = getimagesize($this->getPath());
			$this->height = $info[0];
		}
		return $this->width;
	}
	
	/**
	 * Get image height.
	 *
	 * @return int The image height
	 */
	public function getHeight() {
		if($this->height === null) {
			$info = getimagesize($this->getPath());
			$this->height = $info[1];
		}
		return $this->height;
	}
}