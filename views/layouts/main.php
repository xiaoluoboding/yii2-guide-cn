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
    <!-- syntaxhighlighter -->
    <script type="text/javascript" src="<?php echo Yii::getAlias("@syntax") ?>/scripts/shCore.js"></script>
    <script type="text/javascript" src="<?php echo Yii::getAlias("@syntax") ?>/scripts/shBrushPhp.js"></script>
	<script type="text/javascript" src="<?php echo Yii::getAlias("@syntax") ?>/scripts/shBrushSql.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo Yii::getAlias("@syntax") ?>/styles/shCoreDefault.css"/>
	<script type="text/javascript">
		SyntaxHighlighter.all();
	</script>
</head>
<body>

<?php $this->beginBody() ?>

    <div class="wrap">
		<div class="toper">
    		<?= $header ?>
    	</div>
    
		<div class="container">
			<div class="row" >
        		<?= $content ?>
			</div>
		</div>
    </div>

    <footer class="footer">
    	<?= $footer ?>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
