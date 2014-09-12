<?php
namespace app\models;

class SideMenuModel extends \yii\base\Object {
	
	public $id;
	public $menuname;
	public $flag;
	
	private static $guidelist = [
		'default' => [
			'id' => '0000',
			'menuname' => 'default',
			'flag' => '0',
		],
		'index' => [
			'id' => '0001',
			'menuname' => 'index',
			'flag' => '1',
		],
		'overview' => [
			'id' => '0101',
			'menuname' => 'overview',
			'flag' => '1',
		],
		'upgrade-from-v1' => [
			'id' => '0102',
			'menuname' => 'upgrade-from-v1',
			'flag' => '1',
		],
		'controller' => [
			'id' => '0305',
			'menuname' => 'controller',
			'flag' => '1',
		],
		'components' => [
			'id' => '0501',
			'menuname' => 'components',
			'flag' => '1',
		],
	];
	
	public static function getGuideListMenu($id){
		foreach (self::$guidelist as $guidelist) {
			if (strcasecmp($guidelist['id'], $id) === 0) {
				return new static($guidelist);
			}
		}
		
		return null;
	}
}

?>