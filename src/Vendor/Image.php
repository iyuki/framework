<?php
namespace File;

class Image
{
	/**
	 * Soubor ze superglobální proměnné $_FILES
	 * @access private
	 */
	private $file;

	/**
	 * Obrázek
	 * @access private
	 */
	private $image;

	/**
	 * Šířka obrázku
	 * @access public
	 */
	public $width;

	/**
	 * Výška obrázku
	 * @access public
	 */
	public $height;

	/** 
	 * Typ obrázku
	 * @access public
	 */
	public $type;

	/**
	 * Nahraje obrázek
	 * Konstruktor
	 * @param Array Soubor v superglobální proměnné $_FILES
	 * @access public
	 * @return void
	 */
	public function __construct( $file )
	{
		if( $file != "" ) {
			list( $this->width, $this->height, $this->type ) = getimagesize( $file["tmp_name"] );
			$this->file = $file;
			$this->image = $this->createImage();
		}
	}

	/**
	 * Vytvoří obrázek
	 * @access private
	 * @return Resource Obrázek
	 */
	private function createImage()
	{
		switch( $this->type ) {
			case IMAGETYPE_GIF:
				$image = imagecreatefromgif( $this->file["tmp_name"] );
				break;
			case IMAGETYPE_JPEG:
				$image = imagecreatefromjpeg( $this->file["tmp_name"] );
				break;
			case IMAGETYPE_PNG:
				$image = imagecreatefrompng( $this->file["tmp_name"] );
				break;
			default:
				throw new Exception("This file format is not supported.");
		}

		return $image;
	}

	/** 
	 * Stáhne soubor (na server)
	 * @param String Cesta souboru
	 * @access public
	 * @return void
	 */
	public function download( $path )
	{
		switch( $this->type ) {
			case IMAGETYPE_GIF:
				imagegif( $this->image, $path . ".gif" );
				break;
			case IMAGETYPE_JPEG:
				imagejpeg( $this->image, $path . ".jpg" );
				break;
			case IMAGETYPE_PNG:
				imagepng( $this->image, $path . ".png" );
				break;
			default:
				throw new Exception("This file format is not supported.");
		}
	}

	/* -- FILTRY -- */

	/**
	 * Převede obrázek do stupní šedi
	 * @access public
	 * @return void
	 */
	public function toGrayscale()
	{
		imagefilter( $this->image, IMG_FILTER_GRAYSCALE);
	}

	/**
	 * Převrátí barvy
	 * @access public
	 * @return void
	 */
	public function negate()
	{
		imagefilter( $this->image, IMG_FILTER_NEGATE);
	}

	/**
	 * Změna světlosti
	 * @param Integer Úroveň zesvětlení
	 * @access public
	 * @return void
	 */
	public function changeBrightness( $value )
	{
		imagefilter( $this->image, IMG_FILTER_BRIGHTNESS, $value );
	}

	/**
	 * Změna kontrastu
	 * @param Integer Hodnota kontrastu
	 * @access public
	 * @return void
	 */
	public function changeContrast( $value )
	{
		imagefilter( $this->image, IMG_FILTER_CONTRAST, $value );
	}

	/**
	 * Přebarvení obrázku
	 * @param Array Barva v RGB
	 * @access public
	 * @return void
	 */
	public function colorize( $rgb )
	{
		imagefilter( $this->image, IMG_FILTER_COLORIZE, $rgb[0], $rgb[1], $rgb[2] );
	}

	/**
	 * Zvýraznění hran
	 * @access public
	 * @return void
	 */
	public function edgeDetect()
	{
		imagefilter( $this->image, IMG_FILTER_EDGEDETECT );
	}

	/**
	 * Reliéf
	 * @access public
	 * @return void
	 */
	public function relief()
	{
		imagefilter( $this->image, IMG_FILTER_EMBOSS );
	}

	/**
	 * Gaussovo rozostření
	 * @access public
	 * @return void
	 */
	public function gaussianBlur()
	{
		imagefilter( $this->image, IMG_FILTER_GAUSSIAN_BLUR );
	}

	/**
	 * Vyhlazení
	 * @param Integer Úroveň vyhlazení
	 * @access public
	 * @return void
	 */
	public function smooth( $value )
	{
		imagefilter( $this->image, IMG_FILTER_SMOOTH, $value );
	}

	/**
	 * Pixelizace
	 * @param Integer Úroveň pixelizace
	 * @param Bool Typ pixelizace
	 * @access public
	 * @return void
	 */
	public function pixelate( $value, $type = false )
	{
		imagefilter( $this->image, IMG_FILTER_PIXELATE, $value, $type );
	}

	/**
	 * Sépiový efekt
	 * @access public
	 * @return void
	 */
	public function sepia()
	{
		$this->toGrayscale();
		$this->colorize( array(100, 50, 0) );
	}

	/**
	 * Překlopí obrázek
	 * @param Bool Typ překlopení
	 * @access public
	 * @return void
	 */
	public function flip( $type )
	{
		$temp = imagecreatetruecolor( $this->width, $this->height );

		if( $type == true ) 
			$copy = imagecopyresampled($temp, $this->image, 0, 0, 0, ($this->height-1), $this->width, $this->height, $this->width, (0-$this->height));
		else
			$copy = imagecopyresampled($temp, $this->image, 0, 0, ($this->width-1), 0, $this->width, $this->height, (0-$this->width), $this->height); 
		
		$this->image = $temp;
	}

	/**
	 * Otáčí obrázkem
	 * @param Float Úhel
	 * @access public
	 * @return void
	 */
	public function rotate( $angle )
	{
		$this->image = imagerotate( $this->image, $angle, 0);
	}

}