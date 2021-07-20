<?php
return [
	'siteUrl' => 'http://127.0.0.1/form/',
	'subFolder' => 'form/',
	'indexFile' => 'index.php',
	'defaultController' => 'form',
	'exceptionHandler' => 'handler/exception',
	'errorHandler' => 'handler/error',
	'theme' => 'default',
	'log' => true,
	'errorReporting' => E_ALL,
	'exceptionReporting' => true,
       'timeZone' => 'Asia/Tehran',
	'database' => [
		'connection' => 'mysql:host=localhost:4554;dbname=form;charset=utf8',
		'username' => 'root',
		'password' => '',
		'emulatePrepare' => false,
	],
	'classes' => require BASEPATH.'app/config/classes.php',
];