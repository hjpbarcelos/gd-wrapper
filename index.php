<?php
error_reporting(E_ALL | E_STRICT);
require 'autoload.php';

use GdWrapper\Io\Writer\WriterFactory;
use GdWrapper\Io\Reader\ReaderFactory;
// header('content-type: image/png');
$reader = ReaderFactory::factory('assets/images/file5.jpg');
$resource = $reader->read('assets/images/file5.jpg');

$writer = WriterFactory::factory('png', $resource);
// $writer->write();
