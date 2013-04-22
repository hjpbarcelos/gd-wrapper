<?php
/**
 * Creates class \GdWrapper\Resource\ImageResourceFactory
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

/**
 * Factory for ImageResource objects
 */
class ImageResourceFactory extends AbstractFactory {
    /**
     * @var resource GD2 resource for instantiate objects.
     */
    private $resource;
    
    /**
     * Creates a factory object that will create `ImageResource` objects
     * from `$resource`.
     *
     * @param resource $resource A GD2 image resource.
     *
     * @throws \InvalidArgumentException If `$resource` is not a valid resource.
     */
    public function __construct($resource) {
        parent::__construct('\\GdWrapper\\Resource\\ImageResource');
        $this->setResource($resource);
    }
    
    /**
     *
     * @param resource $resource A GD2 image resource.
     * @throws \InvalidArgumentException If `$resource` is not a valid resource.
     */
    public function setResource($resource) {
        if(!is_resource($resource)) {
            throw new \InvalidArgumentException(
                'Param \'$resource\' should be a resource, '
                . gettype($resource) . ' given'
            );
        }

        $this->resource = $resource;
    }
    
    /**
     * {@inheritdoc}
     *
     * @see GdWrapper\Resource.AbstractFactory::create()
     */
    public function create() {
        try {
            $refl = new ReflectionClass($this->getClassName());
            return $refl->newInstance($this->resource);
        } catch (\ReflectionException $e) {
            throw new \DomainException($e->getMessage(), $e->getCode(), $e);
        }
    }
}