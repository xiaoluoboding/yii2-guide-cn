<?php
namespace app\views\layouts;

use yii;
use yii\widgets\Block;
use app\controllers\AreaDecorator;
?>

<?php AreaDecorator::begin(['viewFile'=>'@app/views/layouts/main.php'])?>
	<!-- 头部布局 -->
	<?php Block::begin(['id' => 'header']);?>
		<div>
			<?php include( Yii::getAlias("@app") . '/views/layouts/header.php');?>
		</div>
	<?php Block::end();?>
	
	<!-- 内容布局 -->
    <?php Block::begin(['id' =>'content']);?>
    	<div class="container">		
			<?= $main_column ?>
		</div>		
    <?php Block::end();?>
	
	<!-- 底部布局 -->
    <?php Block::begin(['id' =>'footer']);?>
			<?php include( Yii::getAlias("@app") . '/views/layouts/footer.php');?>
    <?php Block::end();?>

<?php AreaDecorator::end();?>

