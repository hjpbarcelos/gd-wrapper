<?php

namespace GdWrapper\Io\Reader;

class PngReaderTest extends \PHPUnit_Framework_TestCase {
    private $errors;
    private $reader;
    
    protected function setUp() {
        $this->reader = new PngReader();
        $this->errors = array();
        set_error_handler(array($this, "errorHandler"));
    }
    
    public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
        $this->errors[] = compact("errno", "errstr", "errfile",
            "errline", "errcontext");
    }
    
    public function assertError($errstr, $errno) {
        foreach ($this->errors as $error) {
            if ($error["errstr"] === $errstr
                && $error["errno"] === $errno) {
                return;
            }
        }
        $this->fail("Error with level " . $errno .
            " and message '" . $errstr . "' not found in ",
            var_export($this->errors, TRUE));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function invalidExistentFile() {
        $this->reader->read(ROOT. '/test/assets/images/file1.jpg');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function fakePngFile() {
        $this->reader->read(ROOT. '/test/assets/images/file6.png');
    }
    
    /**
     * @expectedException \GdWrapper\Io\Exception
     * @test
     */
    public function corruptedPngFile() {
        $this->reader->read(ROOT. '/test/assets/images/file7.png');
    }
    
    /**
     * @test
     */
    public function readFileOk() {
        $file = ROOT. '/test/assets/images/file2.png';
        $resource = $this->reader->read($file);
        
        ob_start();
        imagegd2($resource->getRaw());
        $contents = md5(ob_get_clean());
        
        ob_start();
        $fromGd = imagecreatefrompng($file);
        imagegd2($fromGd);
        $expected = md5(ob_get_clean());
        
        $this->assertEquals($expected, $contents);
    }
}
