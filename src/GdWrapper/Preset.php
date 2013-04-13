<?php
/**
 * Defines Preset "enum".
 * 
 * @author Henrique Barcelos
 */

namespace GdWrapper;

/**
 * Contains some preset definitions for image output quality.
 * 
 * Simulates a Java enum.
 * 
 * @author Henrique Barcelos
 * @package GdWrapper
 */
interface Preset 
{
	/**
	 * 100
	 * 
	 * @var integer
	 */
	const IMAGE_QUALITY_MAX = 100;
	
	/**
	 * 90
	 * 
	 * @var integer
	 */
	const IMAGE_QUALITY_HIGH = 90;
	
	/**
	 * 60
	 * 
	 * @var integer
	 */
	const IMAGE_QUALITY_MED = 60;
	
	/**
	 * 40
	 * 
	 * @var integer
	 */
	const IMAGE_QUALITY_LOW = 40;
	
	/**
	 * 30
	 * 
	 * @var integer
	 */
	const IMAGE_QUALITY_DRAFT = 30;
}