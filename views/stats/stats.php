<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 10.08.16
 * Time: 10:59
 */

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

$edate = date('Y-m-d',strtotime(Yii::$app->params['event_date']));
$totalFlights = $flightsModel->find()->count();
$totalBookedFlights = $flightsModel->find()->andWhere('vid > 0')->count();
$totalSlots = $slotsModel->find()->count();
$totalBookedSlots = $slotsModel->find()->andWhere('vid > 0')->count();
$fper = $totalFlights>0?$totalBookedFlights/$totalFlights*100:0;
$sper = $totalSlots>0?$totalBookedSlots/$totalSlots*100:0;
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class="row">
        <h1 class="text-center"><?=Yii::$app->name?> general statistics</h1>
    </div>
    <div class="row">
        <h3 class="text-center">Overall:</h3>
    </div>
    <div class="row">
        <h4>Flights booking progress</h4>
        <div class="col-lg-1 col-sm-1 col-md-1 badge">0</div>
        <div class="col-lg-10 col-sm-10 col-md-10">
            <div class="progress">
                <div class="progress-bar progress-bar-info progress-bar-striped progress-animated" role="progressbar" aria-valuenow="<?=$fper?>"
                 aria-valuemin="0" aria-valuemax="<?=$totalFlights?>" style="width:<?=$fper?>%">
                </div>
            </div>
            <div style="overflow-x: hidden;">
                <i class="fa fa-chevron-up" style="margin-left: <?=$fper?>%"> <?=$totalBookedFlights?></i>
            </div>
        </div>
        <div class="col-lg-1 col-sm-1 col-md-1 badge alert-success"><?=$totalFlights?></div>
    </div>
    <div class="row">
        <h4>Slots booking progress</h4>
        <div class="col-lg-1 col-sm-1 col-md-1 badge">0</div>
        <div class="col-lg-10 col-sm-10 col-md-10">
            <div class="progress">
                <div class="progress-bar progress-bar-info progress-bar-striped progress-animated" role="progressbar" aria-valuenow="<?=$sper?>"
                     aria-valuemin="0" aria-valuemax="<?=$totalSlots?>" style="width:<?=$sper?>%">
                </div>
            </div>
            <div style="overflow-x: hidden;">
                <i class="fa fa-chevron-up" style="margin-left: <?=$sper?>%"> <?=$totalBookedSlots?></i>
            </div>
        </div>
        <div class="col-lg-1 col-sm-1 col-md-1 badge alert-success"><?=$totalSlots?></div>
    </div>
    <hr>
    <div class="row">
        <?php
        $fdata = [];
        foreach($flightsModel::find()->all() as $item)
        {
            $key = $item->airport->icao." (".$item->airport->name.")";
            if(!isset($fdata[$key][$item->isarrival][($item->isarrival==1)?$item->timeto:$item->timefrom]))$fdata[$key][$item->isarrival][($item->isarrival)?$item->timeto:$item->timefrom]=0;
            $fdata[$key][$item->isarrival][($item->isarrival==1)?$item->timeto:$item->timefrom]++;
            //slots
            $s = $slotsModel->find()->andWhere(['airport_id'=>$item->airport_id])->andWhere(['timeslot'=>($item->isarrival==1)?$item->timeto:$item->timefrom])->all();
            foreach($s as $ii){
                if(!isset($fdata[$key][$ii->is_arrival][$ii->timeslot]))
                    $fdata[$key][$ii->is_arrival][$ii->timeslot]=0;
                $fdata[$key][$ii->is_arrival][$ii->timeslot]++;
            }
        }
        foreach($fdata as $airport => $details)
        {
            $arrivals=[]; $departures = [];
            foreach($details[1] as $i=>$k) $arrivals[]=[new JsExpression('Date.parse("'.$edate." ".$i.' GMT")'),$k];
            foreach($details[0] as $i=>$k) $departures[]=[new JsExpression('Date.parse("'.$edate." ".$i.' GMT")'),$k];;
            sort($arrivals);
            sort($departures);
            echo Highcharts::widget([
                'options' => [
                    'title' => ['text' => $airport.' time graph'],
                    'xAxis' => [
                        'type' => 'datetime'
                    ],
                    'yAxis' => [
                        'title' => ['text' => 'Flights']
                    ],
                    'series' => [
                        ['name' => 'Arrivals', 'color'=>'lightgreen','type'=>'areaspline','data' => $arrivals],
                        ['name' => 'Departures', 'type'=>'areaspline', 'data' => $departures]
                    ]
                ]
            ]);
        }
        ?>
    </div>
</div>
