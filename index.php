<?php

error_reporting(E_ALL | E_STRICT);
require 'autoload.php';

use GdWrapper\Resource\ImageResourceFactory;
use GdWrapper\Resource\EmptyResource;
use GdWrapper\Resource\EmptyResourceFactory;

use GdWrapper\Action\ResizeStrategy\Exact as ResizeExact;
use GdWrapper\Action\ResizeStrategy\Proportional as ResizeProportional;
use GdWrapper\Action\ResizeStrategy\KeepRatio as ResizeKeepRatio;

use GdWrapper\Io\Writer\Writer;
use GdWrapper\Io\Writer\WriterFactory;
use GdWrapper\Io\Reader\ReaderFactory;

use GdWrapper\Action\Resize;
use GdWrapper\Action\Crop;
use GdWrapper\Action\CropStrategy\FromEdges as CropFromEdges;
use GdWrapper\Action\CropStrategy\FixedPoints as CropFixedPoints;
use GdWrapper\Action\CropStrategy\Proportional as CropProportional;

use GdWrapper\Geometry\Point;
use GdWrapper\Geometry\Margin\Fixed as FixedMargin;
use GdWrapper\Geometry\Margin\Proportional as ProportionalMargin;
use GdWrapper\Geometry\Position\Aligned;
use GdWrapper\Geometry\Position\FixedPoint;
use GdWrapper\Geometry\Alignment\Start;
use GdWrapper\Geometry\Alignment\Center;
use GdWrapper\Geometry\Alignment\End;

header('content-type: image/jpeg');
$iFactory = new ImageResourceFactory('test/assets/images/file1.jpg');
$src = $iFactory->create();

$resize = new Resize(new ResizeProportional(.5));
// $resize->execute($src);

$crop = new Crop(new CropProportional(new FixedPoint(new Point(200,400)), 0.5));
$crop->execute($src);

$wFactory = new WriterFactory();
$writer = $wFactory->factory('jpg', $src->getRaw());
$writer->write(Writer::STDOUT);

// $resource = new EmptyResource(400, 300);
// $resourceFactory = new EmptyResourceFactory(400, 300);
// $writer = WriterFactory::factory('png', $resourceFactory->create());
// $writer->write(Writer::STDOUT);
