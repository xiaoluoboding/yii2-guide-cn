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
	public $Nameidx;
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
    	$sideMenu = ( array ) SideMenuModel::getGuideListMenu ( $id );
    	$menuname = $sideMenu ['menuname'];
    	return $this->render ( $menuname );
    }
    /**
     * 获取guidelist->enname
     *
     * @param $id
     * @return $Enname
     */
    public function getEnname($id) {
    	$Guidelistdata = Guidelist::findOne ( $id );
  
    	// 赋值常量list->enname索引
    	$this->Nameidx = $Guidelistdata->enname;
    
    	return $this->Nameidx;
    }
    /**
     * 获取guidelist
     *
     * @return guidelistdata
     */
    public function loadGuidelist() {
    	$Guidelistdata = Guidelist::find ()->asArray ()->all ();
    
    	return $Guidelistdata;
    }
}
