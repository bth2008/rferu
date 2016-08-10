<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 10.08.16
 * Time: 10:56
 */

namespace app\controllers;

use app\models\Flights;
use app\models\Slots;
use yii\web\Controller;

class StatsController extends Controller{

    public function actionIndex()
    {
        $flightsModel = new Flights;
        $slotsModel = new Slots();
        return $this->render('stats',['flightsModel'=>$flightsModel,'slotsModel'=>$slotsModel]);
    }
}