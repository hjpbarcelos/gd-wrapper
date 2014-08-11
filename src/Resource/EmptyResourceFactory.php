<?php
/**
 * Creates class \Hjpbarcelos\GdWrapper\Resource\EmptyResourceFactory
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Resource;

/**
 * Factory for creating new empty (blank) image resources.
 */
class EmptyResourceFactory extends AbstractResourceFactory
{
    /**
     * @var int The width of the resource to be created.
     */
    private $width;
    
    /**
     * @var int The height of the resource to be created.
     */
    private $height;
    
    /**
     * Creates a factory object that will create `EmptyResource` objects
     * from `$resource`.
     *
     * @param int $width The width of the resources that will be created
     * @param int $height The height of the resources that will be created
     *
     * @throws \InvalidArgumentException If `$resource` is not a valid resource.
     */
    public function __construct($width, $height)
    {
        parent::__construct('\\Hjpbarcelos\\GdWrapper\\Resource\\EmptyResource');
        $this->setWidth($width);
        $this->setHeight($height);
    }
    
    /**
     * Sets the width of resources created with this factory.
     *
     * @param int $width
     *
     * @return void
     *
     * @throws \InvalidArgumentException If `$width` is less than 0.
     */
    public function setWidth($width) {
        $this->width = (int) $width;
    }
    
    /**
     * Sets the height of resources created with this factory.
     *
     * @param int $height
     *
     * @return void
     *
     * @throws \InvalidArgumentException If `$height` is less than 0.
     */
    public function setHeight($height) {
        $this->height = (int) $height;
    }
    
    /**
     * Returns the width for images created with this factory.
     *
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }
    
    /**
     * Returns the height for images created with this factory.
     *
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }
    
    /**
     * {@inheritdoc}
     *
     * @see Hjpbarcelos\GdWrapper\Resource\AbstractResourceFactory::create()
     */
    public function create()
    {
        try {
            $refl = new \ReflectionClass($this->getClassName());
            return $refl->newInstance($this->width, $this->height);
        } catch (\ReflectionException $e) {
            throw new \DomainException($e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new \LogicException($e->getMessage(), $e->getCode(), $e);
        }
    }
}