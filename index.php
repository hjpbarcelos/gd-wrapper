<?php
error_reporting(E_ALL | E_STRICT);
require 'autoload.php';

use GdWrapper\Io\Writer\WriterFactory;
use GdWrapper\Io\Reader\ReaderFactory;

// header('content-type: image/jpeg');
$reader = ReaderFactory::factory('assets/images/file5.jpg');
$resource = $reader->read('assets/images/file5.jpg');
$writer = WriterFactory::factory('jpg', $resource);
$writer->write();
