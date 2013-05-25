<?php
/**
 * Defines AbstractWriter class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Writer;

use GdWrapper\Resource\Resource;
use GdWrapper\Io\Preset;
use GdWrapper\Io\Exception;

/**
 * Defines an abstract implementation of a I/O device for resources.
 */
abstract class AbstractWriter implements Writer
{
    /**
     * @var Resource The Resource object this object will work on.
     */
    private $resource;

    /**
     * Creates a new output "device".
     *
     * @param resource $resource An image resource.
     */
    public function __construct($resource)
    {
        $this->setResource($resource);
    }

    /**
     * {@inheritdoc}
     *
     * @see \GdWrapper\Io\Writer::getResource()
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     *
     * @see \GdWrapper\Io\Writer::setResource()
     */
    public function setResource($resource)
    {
        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Argument should be a resource, ' . gettype($resource) . ' given');
        }
        $this->resource = $resource;
    }

    /**
     * {@inheritdoc}
     *
     * @param int $quality (optional) The quality of generated image.
     * 		Its value MUST be in a range from 0 to 100.
     *      Otherwise, it will be converted using `$quality % 101`
     *
     * @see \GdWrapper\Io\Writer\Writer::write()
     */
    public function write(
        $pathName,
        $quality = Preset::IMAGE_QUALITY_MAX,
        $_ = null
    ) {
        $quality = abs($quality % 101);
         
        if ($pathName !== null) {
            $dirname = dirname(realpath($pathName));
            if (!is_writable($dirname)) {
                throw new Exception(
                    "You do not have writing permissions in directory '"
                    . $dirname . "'"
                );
            }
        }

        if(!$this->doWrite($pathName, $quality, $_)) {
            throw new Exception(
                "Failed to write image to path '{$pathName}'! Probably you do not
                have the right permissions to do so."
            );
        }
    }

    /**
     * Concrete implementors should implement this operation.
     * This is method is executed at the end of {@link \GdWrapper\Io\Writer\AbstractWriter::write()}
     *
     * @param string $pathName (optiojnal) A path where to save the resource.
     * @param int $quality (optional) The quality of generated image.
     * 		Its value MUST be in a range from 0 to 100.
     * @param mixed $_ (optional) Additional parameters passed to the concrete implementation method.
     *
     * @return void
     *
     * @throws Exception If can't write the contents on file system.
     *
     * @see \GdWrapper\Io\Preset
     */
    abstract protected function doWrite(
        $pathName,
        $quality = Preset::IMAGE_QUALITY_MAX,
        $_ = null
    );
}
