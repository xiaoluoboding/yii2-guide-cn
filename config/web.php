<?php

Yii::setAlias('@assets', '/yii2-guide-cn/assets');
Yii::setAlias('@webdir', '/yii2-guide-cn/web');

$components = require(__DIR__ . '/components.php');
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => $components,
    'params' => $params,
    'modules' => [
    	//添加Guide模块
		'guide' => [
			'class' => 'app\modules\guide\GuideModule',	
		]
	],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
