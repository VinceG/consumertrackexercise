<?php


Yii::setPathOfAlias('root', ROOT_PATH);

return array(
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
			'enableProfiling' => true,
			'enableParamLogging' => true,
		),
		'log'=>array(
			'routes'=>array(
				'trace'=>array(
					'class'=>'CFileLogRoute',
					'levels'=>CLogger::LEVEL_TRACE,
					'logFile'=>'trace.log',
				),
			),
		),
	),
);