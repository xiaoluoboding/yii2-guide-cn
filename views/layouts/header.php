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
                    ['label' => '类参考', 'url' => ['/site/api']],
                    ['label' => '扩展（插件）', 'url' => ['/site/extends']],
                    ['label' => '中文指南', 'url' => ['/site/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
?>