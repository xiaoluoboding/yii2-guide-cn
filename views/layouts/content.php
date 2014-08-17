<?php
namespace app\views\layouts;

use yii;
use yii\widgets\Block;
use app\controllers\AreaDecorator;
?>

<?php AreaDecorator::begin(['viewFile'=>'@app/views/layouts/columns.php'])?>
				
    	<!-- 主界面布局 -->
		<?php Block::begin(['id' =>'main_column']);?>
        		
        	<?php include ( Yii::getAlias("@app") . '/views/layouts/breadcrumbs.php');?>
        		
			<?= $content ?>
				
		<?php Block::end();?>
	
<?php AreaDecorator::end();?>

