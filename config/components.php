<?php
return [ 
		'urlManager' => [ 
				'enablePrettyUrl' => true, 
				//'showScriptName' => false,
				'rules' => [ 
					'guide/<id:\d+>'=>'guide/default/guidelist', 
				],
				'suffix' => '.html',
		],
		'request' => [ 
				// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
				'cookieValidationKey' => 'vX8f-cDKLz2xpMErR-OnGbwj6pKkUEb8' 
		],
		'cache' => [ 
				'class' => 'yii\caching\FileCache' 
		],
		'user' => [ 
				'identityClass' => 'app\models\User',
				'enableAutoLogin' => true 
		],
		'errorHandler' => [ 
				'errorAction' => 'site/error' 
		],
		'mailer' => [ 
				'class' => 'yii\swiftmailer\Mailer',
				// send all mails to a file by default. You have to set
				// 'useFileTransport' to false and configure a transport
				// for the mailer to send real emails.
				'useFileTransport' => true 
		],
		'log' => [ 
				'traceLevel' => YII_DEBUG ? 3 : 0,
				'targets' => [ 
						[ 
								'class' => 'yii\log\FileTarget',
								'levels' => [ 
										'error',
										'warning' 
								] 
						] 
				] 
		],
		'db' => require(__DIR__ . '/db.php'),
];