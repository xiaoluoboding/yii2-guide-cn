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
    <!-- syntaxhighlighter -->
    <script type="text/javascript" src="<?php echo Yii::getAlias("@assets") ?>/syntaxhighlighter/scripts/shCore.js"></script>
    <script type="text/javascript" src="<?php echo Yii::getAlias("@assets") ?>/syntaxhighlighter/scripts/shBrushPhp.js"></script>
	<script type="text/javascript" src="<?php echo Yii::getAlias("@assets") ?>/syntaxhighlighter/scripts/shBrushSql.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo Yii::getAlias("@assets") ?>/syntaxhighlighter/styles/shCoreDefault.css"/>
	<script type="text/javascript">
		SyntaxHighlighter.all();
	</script>
	<!-- Metro BackToUp -->
	<script type="text/javascript">
    $(document).ready(function() {

        $("#leftsead a").hover(function() {
            if ($(this).prop("className") == "youhui") {
                $(this).children("img.hides").show();
            } else {
                $(this).children("img.hides").show();
                $(this).children("img.shows").hide();
                $(this).children("img.hides").animate({
                    marginRight: '0px'
                }, 'slow');
            }
        }, function() {
            if ($(this).prop("className") == "youhui") {
                $(this).children("img.hides").hide('slow');
            } else {
                $(this).children("img.hides").animate({
                    marginRight: '-143px'
                }, 'slow', function() {
                    $(this).hide();
                    $(this).next("img.shows").show();
                });
            }
        });
        $("#top_btn").click(function() {
            if (scroll == "off") return;
            $("html,body").animate({
                scrollTop: 0
            }, 600);
        });

    });
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
