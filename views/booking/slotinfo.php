<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 09.08.16
 * Time: 15:08
 */
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class="row">
        <h1 class="text-center">Private slot booking information</h1>
    </div>
    <div class="row">
        <?php
        echo \yii\widgets\DetailView::widget([
            'model'=>$model,
            'attributes'=>[
                ['label'=>'Airport','value'=>$model->airport->name."(".$model->airport->icao.")"],
                ['label'=>'Time Slot','value'=>$model->timeslot],
                ['label'=>$model->is_arrival?'Arrival from':'Departure to','value'=>$model->icaoto],
                ['label'=>'Booked by','value'=>$model->pilot->firstname." ".$model->pilot->lastname],
                ['label'=>'Booked by VID','value'=>$model->vid],
                ['label'=>'Pilot Rating','format'=>'html','value'=>\yii\helpers\Html::img("https://www.ivao.aero/data/images/ratings/pilot/".$model->pilot->pilot_rating.".gif")],
                ['label'=>'Pilot Division / Country','format'=>'html','value'=>$model->pilot->division." / ".$model->pilot->country]
            ]
        ]);
        ?>
    </div>
    <?php
    if(!Yii::$app->user->isGuest && Yii::$app->user->identity->vid == $model->vid){
    ?>
        <div class="row">
            <?=\yii\bootstrap\Html::a('<i class="fa fa-trash"></i> Cancel this booking',\yii\helpers\Url::to(['/booking/cancelslot','id'=>$model->id]),['class'=>'btn btn-block btn-danger text-center'])?>
        </div>
    <?php
    }
    ?>
</div>
