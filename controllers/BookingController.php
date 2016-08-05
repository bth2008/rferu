<?php

namespace app\controllers;

use app\models\Airports;
use app\models\Flights;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;

class BookingController extends Controller
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

    public function actionIndex()
    {

        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin)
        {
            $model = new Airports();
            if($pdata = Yii::$app->request->post('Airports'))
            {
                if(!empty($pdata['id'])){
                    $model = Airports::findOne($pdata['id']);
                }
                unset($pdata['id']);
                $model->attributes = $pdata;
                $model->save();
                $this->refresh();
            }
        }
        $model = new Airports();
        return $this->render('booking',['model'=>$model]);
    }
    public function actionArrivals($id)
    {
        $model = new Flights();
        $model->airport_id = $id;
        $model->icaoto = $model->airport->icao;
        $model->isarrival = 1;
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin)
        {
            if($p = Yii::$app->request->post('Flights')){
                $model->attributes = $p;
                $model->save();
                $this->refresh();
            }
        }
        return $this->render('arrivals',['model'=>$model]);
    }
    public function actionDepartures($id)
    {
        $model = new Flights();
        $model->airport_id = $id;
        $model->icaofrom = $model->airport->icao;
        $model->isarrival = 0;
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin)
        {
            if($p = Yii::$app->request->post('Flights')){
                $model->attributes = $p;
                $model->save();
                $this->refresh();
            }
        }
        return $this->render('arrivals',['model'=>$model]);
    }
    public function actionBook($id)
    {
        VarDumper::dump($id);
    }
}
?>