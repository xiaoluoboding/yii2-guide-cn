<?php
use yii\helpers\Html;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="<?= Yii::getAlias("@webdir"); ?>/js/jquery-2.1.1.min.js" type="text/javascript"></script>
</head>
<body>

<?php $this->beginBody() ?>

    <div class="wrap">
		<div class="toper">
    		<?= $header ?>
    	</div>
    	
		<div class="content">
			<?= $content ?>
		</div>
    </div>

    <footer class="footer">
    	<?= $footer ?>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
