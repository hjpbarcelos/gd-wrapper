<?php
namespace GdWrapper\Io\Reader;

class ReaderFactoryTest extends \PHPUnit_Framework_TestCase {
    /**
     * @expectedException \DomainException
     * @test
     */
    public function createWithUnsupportedFilePathName() {
        ReaderFactory::factory('someimage.txt');
    }
    
    /**
     * @expectedException \DomainException
     * @test
     */
    public function createWithUnsupportedExtension() {
        ReaderFactory::factory('txt');
    }
    
    /**
     * @test
     */
    public function createWithValidFilePathName() {
        $reader = ReaderFactory::factory(ROOT . '/test/assets/image/file1.jpg');
        $this->assertEquals(new JpgReader(), $reader);
    }
    
    /**
     * @test
     */
    public function createWithValidExtension() {
        $reader = ReaderFactory::factory('jpeg');
        $this->assertEquals(new JpegReader(), $reader);
    }
}