<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\base\Model;
use app\models\Guidelist;

class SiteController extends Controller {
	/**
	 * 调用布局文件
	 *
	 * @var layout
	 */
	public $layout = "content";
	public $Nameidx;
	public function behaviors() {
		return [ 
			'access' => [ 
				'class' => AccessControl::className (),
				'only' => [ 'logout' ],
				'rules' => [ 
					[ 
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'] 
					] 
				] 
			],
			'verbs' => [ 
				'class' => VerbFilter::className (),
				'actions' => [ 
					'logout' => [ 'post' ] 
				] 
			] 
		];
	}
	public function actions() {
		return [ 
				'error' => [ 
						'class' => 'yii\web\ErrorAction' 
				],
				'captcha' => [ 
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null 
				] 
		];
	}
	public function actionIndex() {
		return $this->render ( 'index' );
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
	public function actionLogin() {
		if (! \Yii::$app->user->isGuest) {
			return $this->goHome ();
		}
		
		$model = new LoginForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->login ()) {
			return $this->goBack ();
		} else {
			return $this->render ( 'login', [ 
					'model' => $model 
			] );
		}
	}
	public function actionLogout() {
		Yii::$app->user->logout ();
		
		return $this->goHome ();
	}
	public function actionContact() {
		$model = new ContactForm ();
		if ($model->load ( Yii::$app->request->post () ) && $model->contact ( Yii::$app->params ['adminEmail'] )) {
			Yii::$app->session->setFlash ( 'contactFormSubmitted' );
			
			return $this->refresh ();
		} else {
			return $this->render ( 'contact', [ 
					'model' => $model 
			] );
		}
	}
	public function actionAbout() {
		return $this->render ( 'about' );
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
