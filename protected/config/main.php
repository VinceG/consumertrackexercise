<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('root', ROOT_PATH);
Yii::setPathOfAlias('vendor', ROOT_PATH . '/protected/vendor');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
	array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'iReverse Home Loans',

		// preloading 'log' component
		'preload'=>array('log'),

		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.controllers.*',
		),

		// application components
		'components'=>array(
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning',
					),
				),
			),
			'cache'=>array(
				'class'=>'system.caching.CFileCache',
			),
			'urlManager'=>array(
				'urlFormat'=>'path',
				'showScriptName'=>false,
			),
		),

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
		),
	),
	file_exists($local=dirname(__FILE__).'/params-local.php') ? require($local) : array()
);