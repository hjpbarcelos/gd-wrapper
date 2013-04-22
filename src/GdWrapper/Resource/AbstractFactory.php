<?php
/**
 * Creates class \GdWrapper\Resource\AbstractFactory.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

/**
 * Abstract factory for `\GdWrapper\Resource\Resource` types.
 */
class AbstractFactory {
    /**
     * @var string Fully qualified name for the Resource interface.
     */
    private $superClass = '\GdWrapper\Resource\Resource';
    
    /**
     * @var string The fully qualified name of the class created by the factory.
     */
    private $className;
    
    /**
     * Allows subclasses to initialize default values for `$className`.
     *
     * @param string $className
     *
     * @throws \InvalidArgumentException If `$className` is not a valid class name.
     * @throws \InvalidArgumentException If `$className` is not instantiable.
     * @throws \DomainException If `$className` is not subclass of
     *     \GdWrapper\Resource\Resource.
     */
    protected function __construct($className) {
        $this->setClassName($className);
    }
    
    /**
     * Allows restrict the supertype of the products of this factory.
     *
     * @param string $superClass
     *
     * @return void
     *
     * @throws \InvalidArgumentException If `$className` is not a valid class name.
     * @throws \DomainException If `$className` is not subclass of
     *     \GdWrapper\Resource\Resource.
     */
    final protected function setSuperClass($superClass) {
        try {
            $refl = new \ReflectionClass($className);
            if ($refl->isSubclassOf($this->superClass)) {
                throw new \DomainException(
                    "Class '{$className}' is not a " . $this->superClass . ' subclass'
                );
            }
        } catch (\ReflectionException $e) {
            throw new \InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
        
        $this->superClass = $superClass;
    }
    
    /**
     * Obtains supertype restriction of the products of this factory.
     *
     * @return string
     */
    final protected function getSuperClass() {
        return $this->superClass;
    }
    
    /**
     * Sets class name for this factory object.
     *
     * @param string $className
     *
     * @return void
     *
     * @throws \InvalidArgumentException If `$className` is not a valid class name.
     * @throws \InvalidArgumentException If `$className` is not instantiable.
     * @throws \DomainException If `$className` is not subclass of
     *     \GdWrapper\Resource\Resource.
     */
    final protected function setClassName($className) {
        try {
            $refl = new \ReflectionClass($className);
            if ($refl->isInstantiable()) {
                throw new \InvalidArgumentException(
                    "Class '{$className}' is not instantiable"
                );
            }
            if ($refl->isSubclassOf($this->superClass)) {
                throw new \DomainException(
                    "Class '{$className}' is not a " . $this->superClass . ' subclass'
                );
            }
        } catch (\ReflectionException $e) {
            throw new \InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
        
        $this->className = (string) $className;
    }
    
    /**
     * Obtains class name of this factory object.
     *
     * @return
     */
    final public function getClassName() {
        return $this->className;
    }
    
    /**
     * Creates a concrete instance of `\GdWrapper\Resource\Resource`
     *
     * @return \GdWrapper\Resource\Resource
     */
    abstract public function create();
}