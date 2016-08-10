<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 10.08.16
 * Time: 15:37
 */
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class="row">
        <h1 class="text-center">My reservations</h1>
    </div>
    <div class="row">
        <h4 class="text-center">Flights booked</h4>
        <?php
        echo \yii\grid\GridView::widget([
            'dataProvider'=>$flights,
            'tableOptions'=>['class'=>'table table-condensed'],
            'layout' => '{items}',
            'columns'=>[
                ['attribute'=>'airline','format'=>'html','header'=>false,'value'=>function($data){return \yii\bootstrap\Html::img('https://ivaoru.org/images/airlines/'.$data->airline.'.gif');}],
                ['attribute'=>'flightnumber','format'=>'raw','value'=>function($data){
                    return $data->airline.$data->flightnumber;
                }],
                'gate',
                'aircraft',
                'icaofrom',
                'icaoto',
                'timefrom',
                'timeto',
                ['header'=>'info','format'=>'html','value'=>function($data){
                    return \yii\helpers\Html::a('Booked: '.$data->vid,\yii\helpers\Url::to(['/booking/show','id'=>$data->id]),['class'=>'btn btn-xs btn-warning']);
                }],
            ]
        ]);
        ?>
        <hr>
        <h4 class="text-center">Slots booked</h4>
        <?php
        echo \yii\grid\GridView::widget([
            'dataProvider'=>$slots,
            'tableOptions'=>['class'=>'table table-condensed'],
            'layout' => '{items}',
            'columns'=>[
                'airport.icao',
                ['attribute'=>'timeslot','format'=>'html','value'=>function($data){ return "<i class='fa fa-clock-o'></i><b> $data->timeslot</b>";}],
                ['attribute'=>'icaoto','format'=>'html','value'=>function($data){ return $data->icaoto;},'header'=>'From/To'],
                ['attribute'=>'vid','format'=>'html','header'=>'Info','value'=>function($data){
                    return \yii\helpers\Html::a('Booked by '.$data->vid,\yii\helpers\Url::to(['/booking/showslotinfo/','id'=>$data->id]),['class'=>'btn btn-danger']);

                }],
            ]
        ]);
        ?>
    </div>
</div>
