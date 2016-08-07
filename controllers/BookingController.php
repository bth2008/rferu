<?php

namespace app\controllers;

use app\models\Airports;
use app\models\Flights;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\UploadedFile;

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

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
            $model = new Airports();
            if ($pdata = Yii::$app->request->post('Airports')) {
                if (!empty($pdata['id'])) {
                    $model = Airports::findOne($pdata['id']);
                }
                unset($pdata['id']);
                $model->attributes = $pdata;
                $model->save();
                $this->refresh();
            }
        }
        $model = new Airports();
        return $this->render('booking', ['model' => $model]);
    }

    public function actionArrivals($id)
    {
        $model = new Flights();
        $model->airport_id = $id;
        $model->icaoto = $model->airport->icao;
        $model->isarrival = 1;
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
            Yii::$app->user->returnUrl = '/booking/arrivals/'.$id;
            if ($p = Yii::$app->request->post('Flights')) {
                $model->attributes = $p;
                $model->save();
                $this->refresh();
            }
            if ($uf = UploadedFile::getInstanceByName('batch_loading')) {
                if ($uf->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    $data = \moonland\phpexcel\Excel::import($uf->tempName, ['setFirstRecordAsKeys' => true]);
                    foreach ($data as $item) {
                        if (isset($item['Airline']) && isset($item['From']) && isset($item['Flight']) && isset($item['Gate'])
                            && isset($item['Aircraft']) && isset($item['Departure']) && isset($item['Arrival'])
                        ) {
                            $m = new Flights();
                            $m->airport_id = $id;
                            $m->icaoto = $m->airport->icao;
                            $m->isarrival = 1;
                            $m->airline = $item['Airline'];
                            $m->icaofrom = $item['From'];
                            $m->flightnumber = $item['Flight'];
                            $m->gate = $item['Gate'];
                            $m->aircraft = $item['Aircraft'];
                            $m->timefrom = $item['Departure'];
                            $m->timeto = $item['Arrival'];
                            $m->save();
                        }
                    }
                    $this->refresh();
                }
            }
        }
        return $this->render('arrivals', ['model' => $model]);
    }

    public function actionDepartures($id)
    {
        $model = new Flights();
        $model->airport_id = $id;
        $model->icaofrom = $model->airport->icao;
        $model->isarrival = 0;
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
            Yii::$app->user->returnUrl = '/booking/departures/'.$id;
            if ($p = Yii::$app->request->post('Flights')) {
                $model->attributes = $p;
                $model->save();
                $this->refresh();
            }
            if ($uf = UploadedFile::getInstanceByName('batch_loading')) {
                if ($uf->type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    $data = \moonland\phpexcel\Excel::import($uf->tempName, ['setFirstRecordAsKeys' => true]);
                    foreach ($data as $item) {
                        if (isset($item['Airline']) && isset($item['To']) && isset($item['Flight']) && isset($item['Gate'])
                            && isset($item['Aircraft']) && isset($item['Departure']) && isset($item['Arrival'])
                        ) {
                            $m = new Flights();
                            $m->airport_id = $id;
                            $m->icaofrom = $m->airport->icao;
                            $m->isarrival = 0;
                            $m->airline = $item['Airline'];
                            $m->icaoto = $item['To'];
                            $m->flightnumber = $item['Flight'];
                            $m->gate = $item['Gate'];
                            $m->aircraft = $item['Aircraft'];
                            $m->timefrom = $item['Departure'];
                            $m->timeto = $item['Arrival'];
                            $m->save();
                        }
                    }
                    $this->refresh();
                }
            }
        }
        return $this->render('arrivals', ['model' => $model]);
    }

    public function actionExportDepartures($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
            $model = Flights::find()->andWhere(['airport_id' => $id, 'isarrival' => 0])->all();
            if (!$model) {
                $model = new Flights;
            }
            \moonland\phpexcel\Excel::export([
                'models' => $model,
                'fileName' => 'departures.xlsx',
                'format' => 'Excel2007',
                'columns' => ['airline', 'flightnumber', 'gate', 'aircraft', 'icaoto', 'timefrom', 'timeto'],
                //without header working, because the header will be get label from attribute label.
                'headers' => [
                    'airline' => 'Airline',
                    'flightnumber' => 'Flight',
                    'gate' => 'Gate',
                    'aircraft' => 'Aircraft',
                    'icaoto' => 'To',
                    'timefrom' => 'Departure',
                    'timeto' => 'Arrival'
                ],
            ]);
        }
    }

    public function actionExportArrivals($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
            $model = Flights::find()->andWhere(['airport_id' => $id, 'isarrival' => 1])->all();
            if (!$model) {
                $model = new Flights;
            }
            \moonland\phpexcel\Excel::export([
                'models' => $model,
                'fileName' => 'arrivals.xlsx',
                'format' => 'Excel2007',
                'columns' => ['airline', 'flightnumber', 'gate', 'aircraft', 'icaofrom', 'timefrom', 'timeto'],
                //without header working, because the header will be get label from attribute label.
                'headers' => [
                    'airline' => 'Airline',
                    'flightnumber' => 'Flight',
                    'gate' => 'Gate',
                    'aircraft' => 'Aircraft',
                    'icaofrom' => 'From',
                    'timefrom' => 'Departure',
                    'timeto' => 'Arrival'
                ],
            ]);
        }
    }
    public function actionRemoveFlight($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
            $f = Flights::findOne($id);
            $f->delete();
            $this->redirect(Yii::$app->user->returnUrl);
        }
    }
    public function actionBook($id)
    {
        VarDumper::dump($id);
    }
}

?>