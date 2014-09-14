<?php

namespace app\modules\guide\controllers;

use yii\web\Controller;
use app\modules\guide\models\Guidelist;
use app\models\SideMenuModel;

class DefaultController extends Controller
{
	/**
	 * 调用布局文件
	 *
	 * @var layout
	 */
	public $layout = "content";
	
	/**
	 * 菜单名称索引
	 * @var $Nameidx
	 */
	public $Nameidx;
	
	/**
	 * 启用标志
	 * @var $Flag
	 */
	public $Flag;
	
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * 渲染目录文件
     *
     * @return render()
     */
    public function actionGuidelist($id) {
    	$Enname = $this->getEnname ( $id );
    	
    	return $this->render ( $Enname );
    }
    /**
     * 获取guidelist->enname
     *
     * @param $id
     * @return $Enname
     */
    public function getEnname($id) {
    	$GuidelistData = Guidelist::findOne ( $id );
    	if( $GuidelistData === NULL) {
    		return $this->renderFile('@app/views/site/error.php',['name' => '404','message' => 'd']);
    	}

    	// 赋值常量list->enname索引
    	$this->Nameidx = $GuidelistData->enname;
    	$this->Flag = $GuidelistData->flag;
    	
    	return $this->Nameidx;
    }
    /**
     * 获取guidelist
     *
     * @return GuidelistData
     */
    public function loadGuidelist() {
    	$GuidelistData = Guidelist::find ()->asArray ()->all ();
    
    	return $GuidelistData;
    }
    

}
