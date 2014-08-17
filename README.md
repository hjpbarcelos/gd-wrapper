GdWrapper
=========

GdWrapper is an object oriented wrapper for PHP's GD2 library.

## Installation

### Using composer

Add the following code to your `composer.json`:

```javascript
// ...
"require": {
    // ...
    "hjpbarcelos/gd-wrapper": "dev-master"
}
// ...
```

And then run the following command at your project's root directory:

```bash
$ composer update
```

To autoload the classes from this library, you just need to call the default `composer` autoloader:

```php
require_once 'vendor/autoload.php';
```

### Manually

`GdWrapper` is compatible with [PSR-4][1] and you can find a sample autoloader [here][2].


## Components

### Resources

Represents in-memory image resources. These are actually wrapper objects to GD's native resource type. Every action supported by this library is done over `Resource` objects.

### IO

This package is responsible for image IO (reading from the disc and writting it back/displaying on screen). Each supported image type has its own IO classes.

### Geometry

Helper component that simplifies operation over image dimensions, such as positioning, orientation, margins, etc.

### Action

Actions that can be applied over an image. Currently there are 3 supported actions:

* Resize
* Crop
* Merge

## Usage

### Loading images from disk

If you just need to load files from a specific extensio, you can directly instantiate an image `Reader` for it:

```php
use Hjpbarcelos\GdWrapper\Io\Reader;

$jpegReader = new JpegReader();
$imageResource = $jpegReader->read('/path/to/file.jpg');
```

For gif and png images, the code is analogous, just changing `JpegReader` to `GifReader` or `PngReader`.

When you have a more dynamic image input, where you can have images with different formats, you might consider using a factory to make things easier:

```php
use Hjpbarcelos\GdWrapper\Io\ReaderFactory;

$file = '/path/to/file.png';

$readerFactory = new ReaderFactory();
$reader = $readerFactory->create($file); // Will create a factory based on the type of the image

$imageResource = $reader->read($file);
```

The above code samples are used to create raw GD resources, which are used on basically every function on GD library. However, they are quite hard to handle, since they are not objects and you need to manually free them when not required anymore.

### Using resource wrappers

Once you have created a raw resource, you should wrap it into a `Resource` object. For images read from the disk, there is the `ImageResource` class:

```php
use Hjpbarcelos\GdWrapper\Io\Reader;
use Hjpbarcelos\GdWrapper\Resource\ImageResource;

$jpegReader = new JpegReader();
$imageResource = $jpegReader->read('/path/to/file.jpg');

$objResource = new ImageResource($imageResource);
```

The creation of the resource based on an image from the disk can be delegated to a `ImageResourceFactory` like this:

```php
use Hjpbarcelos\GdWrapper\Resource\ResourceFactory;

$resourceFactory = new ImageResourceFactory('/path/to/file.jpg');
$objResource = $resourceFactory->create(); // Will create a ImageResource object
```

You can create multiple resources based on the same image just by calling the `create` method again:

```php
$resourceFactory = new ImageResourceFactory('/path/to/file.jpg');

$objResource = $resourceFactory->create(); // Will create a ImageResource object
$objResource = $resourceFactory->create(); // Will create another ImageResource object for the same image
```

It's also possible to reuse the same factory to create resource objects for other images, by setting a new image path with the `setPathName` method:

```php
$resourceFactory = new ImageResourceFactory('/path/to/file.jpg');

$objResource = $resourceFactory->create(); // Will create a ImageResource object for /path/to/file.jpg

$resourceFactory->setPathName('/path/to/another_file.png');
$objResource = $resourceFactory->create(); // Will create another ImageResource object for /path/to/another_file.png
```

Notice that you can even change the image type. The `ImageResourceFactory` is smart enough to figure this out and switch to a proper reader.

### Generating image output

In order to generate an output for the image, you must use the `Writer` component from the IO package.

Different from reading images, when you are trying to write them, you should already know *a priori* which format you want your image to assume.

This is how you can convert a JPEG image to PNG:

```php
use Hjpbarcelos\GdWrapper\Resource\ImageResource;
use Hjpbarcelos\GdWrapper\Io\PngWriter;

$resourceFactory = new ImageResourceFactory('/path/to/file.jpg');
$objResource = $resourceFactory->create(); // Will create a ImageResource object for /path/to/file.jpg

$writer = new PngWriter($objResource->getRaw()); // Writers just need the raw GD resource to work
$writer->write('/path/to/new_file.png'); // will save a PNG image on /path/to/new_file.png
```

Sometimes, you want to generate images on the fly instead of outputing it to a file. In this case, you can write to `Writer::STDOUT` to make the output be sent to the standard output (normally, a browser):

```php
header('Content: image/png'); // This is important to make the image be properly rendered by the browser
$writer->write(PngWritter::STDOUT); // will generate a PNG image binary and send it to the browser
```

### Applying actions over images

Actions are applied to images in a cascading fashion, that is, performed actions are cumulative: if you crop an image and then resize it, you will be resizing the cropped version of the image.

#### Resize

Resizing can be done in 3 ways:

* Proportionally
* To an exact fixed size
* Keeping the aspect ratio 

```php
use Hjpbarcelos\GdWrapper\Resource\ResourceFactory;
use Hjpbarcelos\GdWrapper\Action\Resize;
use Hjpbarcelos\GdWrapper\Action\ResizeMode\Proportional as ResizeProportional;
use Hjpbarcelos\GdWrapper\Action\ResizeMode\KeepRatio as ResizeKeepRatio;
use Hjpbarcelos\GdWrapper\Action\ResizeMode\Exact as ResizeExact;

$resourceFactory = new ImageResourceFactory('/path/to/file.jpg');
$objResource1 = $resourceFactory->create();
$objResource2 = $resourceFactory->create();
$objResource3 = $resourceFactory->create(); 

/* Will resize the image to 80% of its original size (both width and height).
 * You can also scale up an image, by passing a value > 1 to ResizeProportional constructor, 
 * but that is inadivisable, since it will deteriorate the image quality.
 */
$resizeMode = new ResizeProportional(0.8); 
$resizeAction = new Resize($resizeMode);

$resizeAction->execute($objResource1); // $objResource1 now refers to the 80%-resized image resource

/* This will resize the image to the exact dimensions passed to ResizeExact construtor (width, height).
 * Needless to say that this can cause distortions (stretching or shrinking) on the image.
 */
$resizeMode = new ResizeExact(400, 300);

$resizeAction->execute($objResource2); // $objResource1 now refers to the 400x300 px resized image resource

/* This is a hybrid resizing mode: you pass both width and length that will be considered the maximum
 * allowed dimensions for the image. 
 *
 * If the image dimensions have the same ratio as the dimensions passed to ResizeKeepRatio constructor, 
 * this action will perform the same way ResizeExact would do.
 * If not, then one of the dimensions will be set to the maximum allowed and the other will be proportionally
 * scaled in order to stay within the predefined limits.
 */

$resizeMode = new ResizeKeepRatio(400, 300); // This is a 4:3 ratio

// Now imagine that $objResource3 refers to an image with 16:9 ratio (1920x1080 px, AKA full HD)
$resizeAction->execute($objResource3); // $objResource1 now refers to a 400x225 px image (keeping the 16:9 ratio)
```

#### Crop

Cropping can be done in 4 ways:

* With fixed dimensions (width and height), based on a referencial position
* Based on fixed points, one working as a referencial and the other used to calculate the width and the height
* Using its edges as referencials, creating "margins"
* Proportionally, based on a referencial position

```php
use Hjpbarcelos\GdWrapper\Resource\ResourceFactory;
use Hjpbarcelos\GdWrapper\Action\Crop;
use Hjpbarcelos\GdWrapper\Action\CropMode\Proportional as CropProportional;
use Hjpbarcelos\GdWrapper\Action\CropMode\FixedDimensions as CropFixedDimensions;
use Hjpbarcelos\GdWrapper\Action\CropMode\FromEdges as CropFromEdges;
use Hjpbarcelos\GdWrapper\Action\CropMode\FixedPoints as CropFixedPoints;

use Hjpbarcelos\GdWrapper\Geometry\Point;

use Hjpbarcelos\GdWrapper\Geometry\Margin\Fixed as FixedMargin;
use Hjpbarcelos\GdWrapper\Geometry\Margin\Proportional as ProportionalMargin;

use Hjpbarcelos\GdWrapper\Geometry\Position\FixedPoint as FixedPointPosition;
use Hjpbarcelos\GdWrapper\Geometry\Position\Aligned as AlignedPosition;

use Hjpbarcelos\GdWrapper\Geometry\Alignment\Center;
use Hjpbarcelos\GdWrapper\Geometry\Alignment\Start;
use Hjpbarcelos\GdWrapper\Geometry\Alignment\End;

$resourceFactory = new ImageResourceFactory('/path/to/file.jpg');
$objResource1 = $resourceFactory->create();
$objResource2 = $resourceFactory->create();
$objResource3 = $resourceFactory->create(); 
$objResource4 = $resourceFactory->create(); 

/* Point(x,y) represents the (x,y) point of the inverted y-axis cartesian plan.
 * Inverted because the way GD referential point is the top left corner of the image.
 *     The x coordinates increase from left to right.
 *     The y coordinates increase from top to down.
 */


/* Fixed points cropping will be done using the rectangle defined by the $start and $end points.
 *
 * Will generate a 800x500 px image, from the point (0,0) to the point (800,500) of the original image.
 *
 * Imagine this: 
 *
 * .----------------------------------------------------------> 1920 px
 * |(0,0)                     + > 800 px                     |
 * |                          +                              |
 * |                          +                              |
 * |                          +                              |
 * |                          +                              |
 * |                          +                              |
 * |                          +                              |
 * |                          +                              |
 * |++++++++++++++++++++++++++.(500,300)                     |
 * |                          v                              |
 * |                        500 px                           |
 * |                                                         |
 * |                                                         |
 * |                                                         |
 * |                                                         |
 * |                                                         |
 * -----------------------------------------------------------
 *                                                           v
 *                                                         1080 px
 */
$cropMode = new CropFixedPoints(new Point(0,0), new Point(800,500));

$cropAction = new Crop($cropMode);
$crop->execute($objResource1);


/* Margin cropping can be done using fixed margins...
 *
 * Will Generate a 1720x880 image, cropping out 100 px from each side of the original image.
 *
 * Imagine this:
 *
 * -----------------------------------------------------------> 1920 px
 * |     A 100px                                             |
 * |     V                                             100 px|
 * |     +++++++++++++++++++++++++++++++++++++++++++++++<--->|
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |<--->+++++++++++++++++++++++++++++++++++++++++++++++     |
 * | 100 px                                     100 px A     |
 * |                                                   V     |
 * -----------------------------------------------------------
 *                                                           v
 *                                                         1080 px
 */
$margin = new FixedMargin(100); // --> same margin for both sides
// To use different vertical and horizontal margins: new FixedMargin(100, 200) --> 100 px on vert. and 200 horiz.
// To use 4 different margins: new FixedMargin(100, 200, 50, 80) --> top, right, bottom, left
$cropMode = new CropFromEdges($margin);
$crop->execute($objResource2);

/* ... or it can be done with proportional margins.
 * The proportion will be relative to the original image dimensions.
 *
 * Imagine this:
 *
 * -----------------------------------------------------------> 2000 px
 * |     A 120px                                             |
 * |     V                                             200 px|
 * |     +++++++++++++++++++++++++++++++++++++++++++++++<--->|
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |     +                                             +     |
 * |<--->+++++++++++++++++++++++++++++++++++++++++++++++     |
 * | 200 px                                     120 px A     |
 * |                                                   V     |
 * -----------------------------------------------------------
 *                                                           v
 *                                                         1200 px
 */
$margin = new ProportionalMargin(0.1); // 10%
// Different margins can be used just like the example above
$cropMode = new CropFromEdges($margin);
$crop->execute($objResource3);

/* FixedDimensionsCrop is a Positioned cropping mode.
 * This means you have to determine a reference position for it.
 * Reference positions can be either a fixed point or anchored to some image notable point (aligned).
 *
 * For fixed point references, the cropping will behave almost like FixedPointsCrop, but you should pass
 * the desired width and height of the cropped image instead of the end point.
 *
 * Imagine this:
 *
 * -----------------------------------------------------------> 1920 px
 * |                                                         |
 * |                                                         |
 * |                                                         |
 * |(200,200).++++++++++++++++++++++++++++++++  A            |
 * |         +                               +  |            |
 * |         +                               +  |            |
 * |         +                               +  |            |
 * |         +                               +  |            |
 * |         +                               +  | 900 px     |
 * |         +                               +  |            |
 * |         +                               +  |            |
 * |         +                               +  |            |
 * |         +                               +  |            |
 * |         +++++++++++++++++++++++++++++++++  V            |
 * |         <----------- 1200 px ----------->               |
 * |                                                         |
 * -----------------------------------------------------------
 *                                                           v
 *                                                         1080 px
 */

$pos = new FixedPosition(new Point(200, 200));
$cropMode = new CropFixedDimensions($pos, 1200, 900);

/* An alignment is either start, center or end, for both vertical and horizontal directions.
 * For the horizontal direction:
 *      start --> left
 *      end   --> right
 *
 * For the vertical direction:
 *      start --> top
 *      end   --> bottom
 */

/* An aligned position consists of a horizontal AND a vertical alignment.
 * The two alignment coordinates will generate a reference point.
 */

/* For aligned reference, the cropping will be aligned to source image anchor points and you should also pass
 * the desired width and height for the cropped image.
 * Imagine this:
 *
 * -----------------------------------------------------------> 1920 px
 * |                                                         |
 * |                                                         |
 * |         +++++++++++++++++++++++++++++++++++++++ A       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + | 800 px|
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +++++++++++++++++++++++++++++++++++++++ V       |
 * |         <-------------- 1200 px -------------->         |
 * |                                                         |
 * -----------------------------------------------------------
 *                                                           v
 *                                                         1080 px
 */

$pos = new AlignedPosition(new Center());
/* If you want different alingments in horizontal and vertical, you can pass a second argument:
 * $post = new AlignedPosition(new Center(), new Start()); // horizontal, vertical = center, top
 */
$cropMode = new CropFixedDimensions($pos, 1200, 800);
$crop->execute($objResource3);

/* Much like the above example, it's also possible do crop an image proportionally, based on a reference position.
 * The arguments to the CropProportional constructor are the position and the proportio.
 *
 * Imagine this:
 *
 * -----------------------------------------------------------> 2000 px
 * |         A  (10%)                                        |
 * |         V 120 px                                        |
 * |         +++++++++++++++++++++++++++++++++++++++ A       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |         +                                     + | 960 px|
 * |         +                                     + |       |
 * |         +                                     + |       |
 * |   (10%) +                                     + |       |
 * |  200 px +                                     + |       |
 * |<------->+++++++++++++++++++++++++++++++++++++++ V       |
 * |         <-------------- 1600 px -------------->         |
 * |                                                         |
 * -----------------------------------------------------------
 *                                                           v
 *                                                         1200 px
 */
```

### Merge

**@TODO**

  [1]: http://www.php-fig.org/psr/psr-4/
  [2]: https://github.com/php-fig/fig-standards/blob/master/accepted/psr-4-autoloader-examples.md

