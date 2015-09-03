<?php
namespace app\controllers;
use yii;
use yii\base\Action;
class BriefingAction extends Action
{
    public $lang;
    public function run()
    {
	return $this->controller->render('briefing',['language'=>$this->lang]);
    }
}
?>