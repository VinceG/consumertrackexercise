<?php
// Load Yii
define('ROOT_PATH', dirname(__FILE__));

// change the following paths if necessary
$yii=ROOT_PATH.'/protected/vendor/yiisoft/yii/framework/yii.php';
$config=ROOT_PATH.'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if(YII_DEBUG) {
        error_reporting(-1);
        ini_set('display_errors', 1);
}

// register composer autoloader
require_once(ROOT_PATH.'/protected/vendor/autoload.php');

// Load Yii
require_once($yii);

$app = Yii::createWebApplication($config);
$app->setTimeZone('America/Los_Angeles');
$app->run();