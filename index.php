<?php

error_reporting(E_ALL | E_STRICT);
require 'autoload.php';

use GdWrapper\Resource\ImageResourceFactory;
use GdWrapper\Action\ResizeStrategy\Exact as ResizeExact;
use GdWrapper\Action\ResizeStrategy\Proportional as ResizeProportional;
use GdWrapper\Action\ResizeStrategy\KeepRatio as ResizeKeepRatio;
use GdWrapper\Io\Writer\Writer;
use GdWrapper\Resource\EmptyResource;
use GdWrapper\Io\Writer\WriterFactory;
use GdWrapper\Io\Reader\ReaderFactory;
use GdWrapper\Resource\EmptyResourceFactory;
use GdWrapper\Action\Resize;
use GdWrapper\Action\Crop;
use GdWrapper\Action\CropStrategy\FixedEdges as CropFixedEdges;
use GdWrapper\Action\CropStrategy\PercentualEdges as CropPercentualEdges;
use GdWrapper\Action\CropStrategy\FixedPoints as CropFixedPoints;
use GdWrapper\Geometry\Point;

header('content-type: image/jpeg');
$iFactory = new ImageResourceFactory('test/assets/images/file1.jpg');
$src = $iFactory->create();

$resize = new Resize(new ResizeProportional(.5));
$dst = $resize->execute($src);

$crop = new Crop(new CropFixedPoints(new Point(10, 10), new Point(810, 810)));
$dst2 = $crop->execute($dst);

$wFactory = new WriterFactory();
$writer = $wFactory->factory('jpg', $dst2->getRaw());
$writer->write(Writer::STDOUT);

// $resource = new EmptyResource(400, 300);
// $resourceFactory = new EmptyResourceFactory(400, 300);
// $writer = WriterFactory::factory('png', $resourceFactory->create());
// $writer->write(Writer::STDOUT);
