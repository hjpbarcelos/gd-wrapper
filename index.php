<?php

error_reporting(E_ALL | E_STRICT);
require 'autoload.php';

use GdWrapper\Io\Writer\Writer;
use GdWrapper\Resource\TrueColorResource;
use GdWrapper\Io\Writer\WriterFactory;
use GdWrapper\Io\Reader\ReaderFactory;
use GdWrapper\Resource\TrueColorResourceFactory;

header('content-type: image/png');
// $reader = ReaderFactory::factory('jpg');
// $resource = $reader->read('test/assets/images/file1.jpg');
// $writer = WriterFactory::factory('jpg', $resource);
// $writer->write(Writer::STDOUT);

// $resource = new TrueColorResource(400, 300);
$resourceFactory = new TrueColorResourceFactory(400, 300);
$writer = WriterFactory::factory('png', $resourceFactory->create());
$writer->write(Writer::STDOUT);
