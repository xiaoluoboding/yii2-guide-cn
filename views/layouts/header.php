<?php

 use yii\bootstrap\Nav;
 use yii\bootstrap\NavBar;
 
?>
<?php
    NavBar::begin([
        'brandLabel' => 'Yii框架2.0中文开发文档',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            '<li><a href="http://www.yiiframework.com/doc-2.0/index.html" >类参考</a></li>',
            [
    			'label' => '扩展',
    			'items' => [
    				['label' => 'apidoc', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-apidoc-index.html'],
    				['label' => 'authclient', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-authclient-index.html'],
                    ['label' => 'bootstrap', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-bootstrap-index.html'],
                    ['label' => 'codeception', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-codeception-index.html'],
                    ['label' => 'composer', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-composer-index.html'],
                    ['label' => 'debug', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-debug-index.html'],
                    ['label' => 'elasticsearch', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-elasticsearch-index.html'],
                    ['label' => 'faker', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-faker-index.html'],
                    ['label' => 'gii', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-gii-index.html'],
                    ['label' => 'imagine', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-imagine-index.html'],
                    ['label' => 'jui', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-jui-index.html'],
                    ['label' => 'mongodb', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-mongodb-index.html'],
                    ['label' => 'redis', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-redis-index.html'],
                    ['label' => 'smarty', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-smarty-index.html'],
                    ['label' => 'sphinx', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-sphinx-index.html'],
                    ['label' => 'swiftmailer', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-swiftmailer-index.html'],
                    ['label' => 'twig', 'url' => 'http://www.yiiframework.com/doc-2.0/ext-twig-index.html'],
    			],
    			'url' => ['/extends']
			],
            ['label' => '中文权威指南', 'url' => ['/guide/1']],
    		/*[	'label' => '实用教程',
    		 	'url' => ['/tutorial/index']
			],
    		 '<div class="navbar-form navbar-left" role="search">
    			<div class="form-group">
    				<input type="text" id="searchbox" class="form-control" placeholder="Search"/>
    			</div>
    		</div>', */
            
        ],
    ]);
    echo Nav::widget([
    	'options' => ['class' => 'navbar-nav navbar-right'],
    	'items' => [
			['label' => '关于', 'url' => ['/site/about']],
    	],
    ]);
    NavBar::end();
?>