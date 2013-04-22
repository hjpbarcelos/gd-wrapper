<?php

error_reporting(E_ALL | E_STRICT);
require 'autoload.php';

use GdWrapper\Action\ResizeStrategy\Exact;
use GdWrapper\Action\ResizeStrategy\Proportional;
use GdWrapper\Io\Writer\Writer;
use GdWrapper\Resource\EmptyResource;
use GdWrapper\Io\Writer\WriterFactory;
use GdWrapper\Io\Reader\ReaderFactory;
use GdWrapper\Resource\EmptyResourceFactory;
use GdWrapper\Action\Resize;

header('content-type: image/jpeg');
$reader = ReaderFactory::factory('jpg');
$src = $reader->read('test/assets/images/file1.jpg');

$resize = new Resize($src, new Proportional(400, 300));
$dst = $resize->execute();

$writer = WriterFactory::factory('jpg', $dst);
$writer->write(Writer::STDOUT);

// $resource = new EmptyResource(400, 300);
// $resourceFactory = new EmptyResourceFactory(400, 300);
// $writer = WriterFactory::factory('png', $resourceFactory->create());
// $writer->write(Writer::STDOUT);
