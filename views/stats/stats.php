<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 10.08.16
 * Time: 10:59
 */
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
</div>
