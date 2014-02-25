<?php
namespace framework\captcha;
use framework\captcha\exception\CaptchaException;
use framework\session\Session;
use framework\request\Request;

/**
 * Captcha
 * create easy captcha image 
 *
 * @use Captcha::create() create new captcha image
 * @use Captcha::validate() validate captcha
 * @use Captcha::font set font path
 * @use Captcha::width set image width
 * @use Captcha::height set image height
 * @use Captcha::text set captcha text
 *
 * @author		saeed johari <foreach@live.com>
 * @package		captcha
 * @since		1.0
 * @copyright	(c) 2014 all rights reserved
 */
class Captcha
{
	/**
	 * captcha session name
	 */
	const SESSION_NAME = 'captcha';
	
	/**
	 * captcha font path
	 *
	 * @access public
	 * @var string
	 */
	public $font;
	
	/**
	 * captcha image with
	 *
	 * @access public
	 * @var integer
	 */
	public $width = 60;
	
	/**
	 * captcha image height
	 *
	 * @access public
	 * @var integer
	 */
	public $height = 30;
	
	/**
	 * captcha text
	 *
	 * @access public
	 * @var integer|string
	 */
	public $text = 999;
	
	/**
	 * class constructor
	 *
	 * initialize captcha configs
	 * @param array $config, configs
	 */
	public function __construct($config = [])
	{
		if(!extension_loaded('gd'))
			throw new CaptchaException('GD extension not loaded');
		if(isset($config['width']))
			$this->width = $config['width'];
		if(isset($config['height']))
			$this->height = $config['height'];
		if(isset($config['text']))
			$this->text = $config['text'];
		if(isset($config['font']))
			$this->font = $config['font'];
		else
			$this->font = FRAMEWORK.'captcha/SpicyRice.ttf';
	}
	
	/**
	 * create captcha image and set to session
	 *
	 * @access public
	 * @return void
	 */
	public function create()
	{
		Session::instance()->open();
		Session::instance()->set(self::SESSION_NAME,$this->text);
		
		$img = imagecreate($this->width,$this->height);
		$background = imagecolorallocate($img,255,255,255);
		$color = imagecolorallocate($img,0,0,140);

              for($i=0; $i<=8; $i++) {
                     imagerectangle($img,rand(0,$this->width),rand(0,$this->height),rand(0,$this->width),rand(0,$this->height),$color);
              }

		imagettftext($img,rand(20,$this->height/2),rand(-2,2),$this->width/6,$this->height/1.5,$color,$this->font,$this->text);

		header('Content-Type:image/png');
		imagepng($img);
	}
	
	/**
	 * validate captcha
	 *
	 * @param string $captcha, captcha value
	 * @access public
	 * @return boolean
	 */
	public function validate($captcha)
	{
		Session::instance()->open();
		if($captcha == (string)Session::instance()->get(self::SESSION_NAME))
			return true;
		else
			return false;
	}
}