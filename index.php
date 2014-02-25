<?php
/**
 * entry script
 *
 * @author        saeed johari <foreach@live.com>
 * @since         1.0
 * @copyright     (c) 2014 all rights reserved
 */
define('BASEPATH',str_replace('\\','/',dirname(__FILE__)).'/');
define('FRAMEWORK',BASEPATH.'source/framework/');
define('LOGPATH',BASEPATH.'app/');
require FRAMEWORK.'framework.php';
Framework::instance()->run();
?>