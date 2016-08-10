<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 10.08.16
 * Time: 15:35
 */

namespace app\controllers;

use app\models\Flights;
use app\models\Slots;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class MyController extends Controller
{
    public function actionIndex()
    {
        if(!\Yii::$app->user->isGuest) {
            $flights = new ActiveDataProvider(['query'=>Flights::find()->andWhere(['vid' => \Yii::$app->user->identity->vid]),'pagination'=>false,'sort'=>false]);
            $slots = new ActiveDataProvider(['query'=>Slots::find()->andWhere(['vid' => \Yii::$app->user->identity->vid]),'pagination'=>false,'sort'=>false]);
            return $this->render('my_reservations', ['flights' => $flights,'slots'=>$slots]);
        }
        else{
            return $this->redirect('/site/login');
        }
    }
}