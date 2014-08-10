<?php
namespace app\modules\guide\views\layouts;

use yii;
use yii\widgets\Block;
use app\controllers\AreaDecorator;
?>

<?php AreaDecorator::begin(['viewFile'=>'@app/modules/guide/views/layouts/columns.php'])?>
				
		<!-- 侧边栏布局 -->
    	<?php Block::begin(['id' =>'list_column']);?>
    		<?php include( Yii::getAlias("@app") . '/modules/guide/views/layouts/listgroups.php');?>
    	<?php Block::end();?>
    		
    		
    	<!-- 主界面布局 -->
		<?php Block::begin(['id' =>'main_column']);?>
        		
        	<?php include ( Yii::getAlias("@app") . '/views/layouts/breadcrumbs.php');?>
        		
			<?= $content ?>
				
		<?php Block::end();?>
			

<?php AreaDecorator::end();?>

