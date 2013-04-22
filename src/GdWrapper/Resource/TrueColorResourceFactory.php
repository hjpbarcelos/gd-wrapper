<?php
/**
 * Creates class \GdWrapper\Resource\TrueColorResourceFactory
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

/**
 * Factory for creating new empty (blank) image resources.
 */
class TrueColorResourceFactory extends AbstractFactory {
    /**
     * @var int The width of the resource to be created.
     */
    private $width;
    
    /**
     * @var int The height of the resource to be created.
     */
    private $height;
    
    /**
     * Creates a factory object that will create `ImageResource` objects
     * from `$resource`.
     *
     * @param int $width The width of the resources that will be created
     * @param int $height The height of the resources that will be created
     *
     * @throws \InvalidArgumentException If `$resource` is not a valid resource.
     */
    public function __construct($width, $height) {
        parent::__construct('\\GdWrapper\\Resource\\TrueColorResource');
        $this->setWidth($width);
        $this->setHeight($height);
    }
    
    public function setWidth($width) {
        $this->width = (int) $width;
    }
    
    public function setHeight($height) {
        $this->height = (int) $height;
    }
    
    /**
     * {@inheritdoc}
     *
     * @see GdWrapper\Resource.AbstractFactory::create()
     */
    public function create() {
        try {
            $refl = new \ReflectionClass($this->getClassName());
            return $refl->newInstance($this->width, $this->height);
        } catch (\ReflectionException $e) {
            throw new \DomainException($e->getMessage(), $e->getCode(), $e);
        }
    }
}