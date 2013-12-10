<?php
// Load Yii
define('ROOT_PATH', dirname(dirname(__FILE__)));

// change the following paths if necessary
$yiic=ROOT_PATH.'/protected/vendor/yiisoft/yii/framework/yiic.php';
$config=ROOT_PATH.'/protected/config/console.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// register composer autoloader
require_once(ROOT_PATH.'/protected/vendor/autoload.php');

// Load Yii
require_once($yiic);