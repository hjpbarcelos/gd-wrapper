<?php
namespace GdWrapper\Io\Reader;

class ReaderFactoryTest extends \PHPUnit_Framework_TestCase {
    /**
     * @expectedException \DomainException
     * @test
     */
    public function createWithUnsupportedExtension() {
        ReaderFactory::factory('someimage.txt');
    }
}