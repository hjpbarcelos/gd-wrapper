<?php
/**
 * Defines ReaderFactory class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

use GdWrapper\Resource\AbstractResourceFactory;
use GdWrapper\Io\Reader\ReaderFactory;
use GdWrapper\Resource\ImageResource;

/**
 * Factory for `\GdWrapper\Resource\ImageResource` type.
 */
class ImageResourceFactory extends AbstractResourceFactory
{
    /**
     * @var string The path to the file from which resources will be created.
     */
    private $pathName;
    
    /**
     * @var \GdWrapper\Io\Reader\Reader The reader object that will create the resource.
     */
    private $reader;
    
    /**
     * @var \GdWrapper\Io\Reader\ReaderFactory The factory for reader objects.
     */
    private $readerFactory;
    
    /**
     * Creates a factory for image file based resources.
     *
     * @param string $pathName The path to the file from which resources will be created.
     * @param \GdWrapper\Io\Reader\ReaderFactory $readerFactory Factory for objects that will
     *     read an image and create a GD2 resource form it.
     * @throws \DomainException If `$pathName` does not point to a supported format image file.
     */
    public function __construct($pathName, ReaderFactory $readerFactory = null)
    {
        if ($readerFactory === null) {
            $readerFactory = new ReaderFactory();
        }
        $this->setReaderFactory($readerFactory);
        
        $this->setClassName('\\GdWrapper\\Resource\\ImageResource');
        $this->setPathName($pathName);
    }
    
    /**
     * Sets the factory for objects that will read an image and create a GD2 resource form it.
     *
     * @param \GdWrapper\Io\Reader\ReaderFactory $readerFactory
     */
    public function setReaderFactory(ReaderFactory $readerFactory)
    {
        $this->readerFactory = $readerFactory;
    }
    
    /**
     * Sets the factory for objects that will read an image and create a GD2 resource form it.
     *
     * @return \GdWrapper\Io\Reader\ReaderFactory
     */
    public function getReaderFactory()
    {
        return $this->readerFactory;
    }
    
    /**
     * Sets the path name of the file from which resources will be created.
     *
     * Note:
	 *
	 * For custom implementations of Reader interface, they must follow the convention:
	 * <code>
	 * \GdWrapper\Io\Writer\&lt;TYPE&gt;Writer
	 * </code>
	 *
	 * Notice that `<TYPE>` MUST be in `StudlyCaps`.
	 *
     * @param string $pathName The path to the file from which resources will be created.
     *
     * @throws \DomainException If `$pathName` does not point to a supported format image file.
     */
    public function setPathName($pathName)
    {
        $this->pathName = (string) $pathName;
        $this->reader = $this->readerFactory->factory($this->pathName);
    }
    
	/**
	 *
	 * {@inheritdoc}
	 *
	 * @see GdWrapper\Resource\AbstractResourceFactory::create()
	 */
	public function create()
	{
	    try {
	        $reflection = new \ReflectionClass($this->getClassName());
	        return $reflection->newInstance(
	            $this->reader->read($this->pathName)
            );
	    } catch (\DomainException $e) {
	        throw $e;
	    } catch (\Exception $e) {
            throw new \LogicException($e->getMessage(), $e->getCode(), $e);
	    }
	}
}
