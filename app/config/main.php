<?php
return [
	'siteUrl' => 'http://localhost/Zarinpal/',
	'subFolder' => 'Zarinpal',
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
		'connection' => 'mysql:host=localhost;dbname=zarinpal;charset=utf8',
		'username' => 'root',
		'password' => '',
		'emulatePrepare' => false,
	],
	'classes' => require BASEPATH.'app/config/classes.php',
];