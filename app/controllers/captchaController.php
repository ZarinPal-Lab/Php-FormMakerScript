<?php
namespace app\controllers;
use app\components\Controller;
use framework\captcha\Captcha;

class CaptchaController extends Controller
{
	public $defaultAction = 'create';
	
	public function actionCreate()
	{
              $text = substr(md5(rand()),0,5);
		$c = new Captcha(
					[
						'width' => 120,
						'height' => 30,
						'text' => $text,
					]
		);
		$c->create();
	}
}