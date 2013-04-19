<?php
error_reporting(E_ALL | E_STRICT);
require 'autoload.php';

use GdWrapper\Io\Writer\Writer;
use GdWrapper\Io\Writer\WriterFactory;
use GdWrapper\Io\Reader\ReaderFactory;

// header('content-type: image/jpeg');
$reader = ReaderFactory::factory('jpg');
$resource = $reader->read('test/assets/images/file1.jpg');
$writer = WriterFactory::factory('jpg', $resource);
$writer->write(Writer::STDOUT);
