<?php
namespace app\components;
use app\components\Controller;

class AController extends Controller
{
	public function init()
	{
	       parent::init();
              $this->siteTheme = $this->theme;
		$this->theme = 'admin';
	}
	
	public function createPassword($pw)
	{
		return hash('sha1',$pw);
	}
}