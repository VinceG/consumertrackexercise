<?php

Yii::setPathOfAlias('root', ROOT_PATH);

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray(
	array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'My Console Application',

		// preloading 'log' component
		'preload'=>array('log'),

		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
		),

		'params' => array(
			'composer.callbacks' => array(
				'pre-install' => array('yiic', 'installhandler', 'preinstall'),
				'post-install' => array('yiic', 'installhandler', 'postinstall'),
				'pre-update' => array('yiic', 'installhandler', 'preupdate'),
				'post-update' => array('yiic', 'installhandler', 'postupdate'),
			),
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
		),
	),
	file_exists($local=dirname(__FILE__).'/params-local.php') ? require($local) : array()
);