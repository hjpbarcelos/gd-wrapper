<?php

error_reporting(E_ALL | E_STRICT);
require 'autoload.php';

use GdWrapper\Resource\ImageResourceFactory;
use GdWrapper\Resource\EmptyResource;
use GdWrapper\Resource\EmptyResourceFactory;

use GdWrapper\Action\ResizeStrategy\Exact as ResizeExact;
use GdWrapper\Action\ResizeStrategy\Proportional as ResizeProportional;
use GdWrapper\Action\ResizeStrategy\KeepRatio as ResizeKeepRatio;

use GdWrapper\Action\MergeStrategy\SaveAlphaChannel as SaveAlphaChannel;

use GdWrapper\Io\Writer\Writer;
use GdWrapper\Io\Writer\WriterFactory;
use GdWrapper\Io\Reader\ReaderFactory;

use GdWrapper\Action\Resize;
use GdWrapper\Action\Crop;
use GdWrapper\Action\Merge;
use GdWrapper\Action\CropStrategy\FromEdges as CropFromEdges;
use GdWrapper\Action\CropStrategy\FixedPoints as CropFixedPoints;
use GdWrapper\Action\CropStrategy\Proportional as CropProportional;
use GdWrapper\Action\CropStrategy\FixedDimensions as CropFixedDimensions;

use GdWrapper\Geometry\Point;
use GdWrapper\Geometry\Margin\Fixed as FixedMargin;
use GdWrapper\Geometry\Margin\Proportional as ProportionalMargin;
use GdWrapper\Geometry\Position\Aligned;
use GdWrapper\Geometry\Position\FixedPoint;
use GdWrapper\Geometry\Alignment\Start;
use GdWrapper\Geometry\Alignment\Center;
use GdWrapper\Geometry\Alignment\End;

header('content-type: image/png');
$iFactory = new ImageResourceFactory('test/assets/images/file1.jpg');
$src = $iFactory->create();

// PNG image with alpha transparency
$iFactory->setPathName('test/assets/images/file5.png');
$mergeRes = $iFactory->create();

$resize = new Resize(new ResizeKeepRatio(1800, 1000));
$resize->execute($src);

$crop = new Crop(new CropFixedDimensions(new Aligned(new Center()), 800, 500));
$crop->execute($src);

$merge = new Merge($mergeRes, new Aligned(new End(new FixedMargin(10))), 50, new SaveAlphaChannel());
$merge->setResourceFactoryClass('\\GdWrapper\\Resource\\TransparentResourceFactory');
$merge->execute($src);


$wFactory = new WriterFactory();
$writer = $wFactory->factory('png', $src->getRaw());
$writer->write(Writer::STDOUT);

// $resource = new EmptyResource(400, 300);
// $resourceFactory = new EmptyResourceFactory(400, 300);
// $writer = WriterFactory::factory('png', $resourceFactory->create());
// $writer->write(Writer::STDOUT);
