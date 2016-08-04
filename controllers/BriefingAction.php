<?php
namespace app\controllers;

use yii;
use yii\base\Action;

class BriefingAction extends Action
{
    public $lang;
    public $model;

    public function run()
    {
        return $this->controller->render('briefing', ['model' => $this->model]);
    }
}

?>