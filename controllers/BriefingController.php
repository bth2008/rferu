<?php

namespace app\controllers;

use app\models\Content;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BriefingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        $ret = [];
        foreach (Yii::$app->params["languages"] as $lng => $name) {
            $model = Content::find()->andWhere('name="briefing"')->andWhere('language="'.$lng.'"')->one();
            $ret[$lng] = ['class' => BriefingAction::className(), 'model' => $model];
        }
        return $ret;
    }
}
