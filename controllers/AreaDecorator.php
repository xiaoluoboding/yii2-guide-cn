<?php

namespace app\controllers;

use yii\base\Widget;

class AreaDecorator extends Widget {
	public $viewFile;
	public $params = [ ];
	public $ids = [ ];
	public function init() {
		if ($this->viewFile === null) {
			throw new InvalidConfigException ( 'ContentDecorator::viewFile must be set.' );
		}
		ob_start ();
		ob_implicit_flush ( false );
	}
	public function run() {
		$params = $this->params;
		$params ['content'] = ob_get_clean ();
		
		$blocks = $this->view->blocks;
		if (count ( $this->ids ) > 0) {
			foreach ( $blocks as $id => $block ) {
				if (in_array ( $id, $this->ids )) {
					$params [$id] = $block;
					unset ( $this->view->blocks [$id] );
				}
			}
		} else {
			foreach ( $blocks as $id => $block ) {
				$params [$id] = $block;
				unset ( $this->view->blocks [$id] );
			}
		}
		
		echo $this->view->renderFile ( $this->viewFile, $params );
	}
}
?>