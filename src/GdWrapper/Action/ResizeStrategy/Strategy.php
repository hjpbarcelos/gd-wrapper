<?php
namespace GdWrapper\Action\ResizeStrategy;

use GdWrapper\Resource\Resource;

interface Strategy
{
    public function getNewDimensions($width, $height);
}