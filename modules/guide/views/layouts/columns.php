<?php
namespace app\views\layouts;

use yii;
use yii\widgets\Block;
use app\controllers\AreaDecorator;
?>

<?php AreaDecorator::begin(['viewFile'=>'@app/modules/guide/views/layouts/main.php'])?>
	<!-- 头部布局 -->
	<?php Block::begin(['id' => 'header']);?>
		<div>
			<?php include( Yii::getAlias("@app") . '/views/layouts/header.php');?>
		</div>
	<?php Block::end();?>
	
	<!-- 内容布局 -->
    <?php Block::begin(['id' =>'content']);?>
    				
    	<div class="col-md-2 col-sm-4" >
    		<?= $list_column ?>
    	</div>
    		
    	<div class="col-md-8 col-sm-8">
			<?= $main_column ?>
		</div>
		
		<div class="col-md-2 col-sm-4" >
    		 <!-- 返回顶部 -->
		    <div id="leftsead">
		        <ul>
		            <li>
		                <a href="http://weibo.com/wwwxlbdnet" target="_blank">
		                    <img src="<?= Yii::getAlias("@webdir");?>/images/weibo_h.png" width="131" height="49" class="hides" />
		                    <img src="<?= Yii::getAlias("@webdir");?>/images/weibo_s.png" width="47" height="49" class="shows" />
		                </a>
		            </li>
		            <li>
		                <a href="http://www.xlbd.net" target="_blank" >
		                    <img src="<?= Yii::getAlias("@webdir");?>/images/blog_h.png" width="131" height="49" class="hides" />
		                    <img src="<?= Yii::getAlias("@webdir");?>/images/blog_s.png" width="47" height="49" class="shows" />
		                </a>
		            </li>
		            <li>
		                <a id="top_btn">
		                    <img src="<?= Yii::getAlias("@webdir");?>/images/back_h.png" width="131" height="49" class="hides" />
		                    <img src="<?= Yii::getAlias("@webdir");?>/images/back_s.png" width="47" height="49" class="shows" />
		                </a>
		            </li>
		        </ul>
		    </div>
		    <!--leftsead end-->
    	</div>
				
    <?php Block::end();?>
	
	<!-- 底部布局 -->
    <?php Block::begin(['id' =>'footer']);?>
			<?php include( Yii::getAlias("@app") . '/views/layouts/footer.php');?>
    <?php Block::end();?>

<?php AreaDecorator::end();?>

