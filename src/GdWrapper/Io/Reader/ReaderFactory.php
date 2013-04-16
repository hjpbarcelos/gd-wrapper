<?php
/**
 * Defines ReaderFactory class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use \GdWrapper\Resource\Resource;

/**
 * Defines an abstract implementation of a input "device" for resources.
 */
class ReaderFactory
{
	/**
	 * Returns a concrete instance of a Reader based on the file extension of `$path`.
	 *
	 * Note:
	 *
	 * For custom implementations of Writer interface, it must follow the convention:
	 * <code>
	 * \GdWrapper\Io\Writer\&lt;TYPE&gt;Writer
	 * </code>
	 *
	 * Notice that `<TYPE>` MUST be in `StudlyCaps`.
	 *
	 * @param string $path the path to an image file.
	 *
	 * @return \GdWrapper\Io\Reader\Reader A concrete implementation of Reader
	 *
	 * @throws \DomainException If the file type is not currently supported.
	 */
	public static function factory($path)
	{
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$className = __NAMESPACE__ . '\\' . ucfirst(strtolower($type)) . 'Reader';
		try {
			$reflection = new \ReflectionClass($className);
			return $reflection->newInstance();
		} catch(\ReflectionException $e) {
			throw new \DomainException("Extension '{$type}' not supported!");
		}
	}
}
