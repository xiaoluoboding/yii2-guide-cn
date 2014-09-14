<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

$this->title = $name;
?>
<div class="site-error">
	<div class="container">
		<p>&nbsp;<p>
		<p>&nbsp;<p>
	    <h1><?= nl2br(Html::encode($message)) ?></h1>
	
	    <div class="alert alert-danger">
	        	404.( ¯ □ ¯ ) 未找到页面!
	    </div>
	</div>
</div>
