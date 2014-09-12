<?php
use yii\helpers\Html; 

$guidelist = Yii::$app->controller->loadGuidelist();
$ActiveId = Yii::$app->controller->Nameidx;
?>
<div class="list-group">
<?php
foreach ($guidelist as $k => $v ) {
	
	$id = $v['id'];
	$label = Html::encode($v['cnname']);
	echo Html::a($label, ['default/guidelist', 'id' => $id], [
		'class' => $v['enname'] === $ActiveId ? 'list-group-item active' : 'list-group-item',
	]);
}
?>
</div>
