<?php

namespace GdWrapper\Io\Reader;

/**
 * Note:
 * Tests for \GdWrapper\Io\Reader\AbstractReader are in this test case.
 *
 * @author Henrique Barcelos
 */
class JpegReaderTest extends \PHPUnit_Framework_TestCase {
    private $errors;
    private $reader;
    
    protected function setUp() {
        $this->reader = new JpegReader();
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
    public function invalidFilePath() {
        $this->reader->read(ROOT. '/test/assets/images/fileXXXXX.jpg');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function invalidExistentFile() {
        $this->reader->read(ROOT. '/test/assets/images/file2.png');
    }
    
    /**
     * File `assets/images/file3.jpg` must hava no read permissions.
     *
     * @expectedException \GdWrapper\Io\Exception
     * @test
     */
    public function unreadableFile() {
        $this->reader->read(ROOT. '/test/assets/images/file3.jpg');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @test
     */
    public function fakeJpegFile() {
        $this->reader->read(ROOT. '/test/assets/images/file4.jpg');
    }
    
    /**
     * @expectedException \GdWrapper\Io\Exception
     * @test
     */
    public function corruptedJpegFile() {
        try {
            $this->reader->read(ROOT. '/test/assets/images/file5.jpg');
        } catch (\GdWrapper\Io\Exception $e) {
            $this->assertError("imagecreatefromjpeg(): '" . ROOT
                . "/test/assets/images/file5.jpg' is not a valid JPEG file", 2);
            throw $e;
        }
    }
    
    /**
     * @test
     */
    public function readFileOk() {
        $file = ROOT. '/test/assets/images/file1.jpg';
        $resource = $this->reader->read($file);
        
        ob_start();
        imagegd2($resource->getRaw());
        $contents = md5(ob_get_clean());
        
        ob_start();
        $fromGd = imagecreatefromjpeg($file);
        imagegd2($fromGd);
        $expected = md5(ob_get_clean());
        
        $this->assertEquals($expected, $contents);
    }
}
