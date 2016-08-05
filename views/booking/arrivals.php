<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 04.08.16
 * Time: 15:15
 */
$dataProvider = $model->dataprovider;
$dataProvider->pagination = false;
$dataProvider->sort = false;
$act = $model->isarrival ==1 ? "Arrivals": "Departures";
$actother = $model->isarrival != 1 ? "arrivals": "departures";
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class="row">
            <h1 class="text-left"> <?=$act?>: <?=$model->airport->name?>(<?=$model->airport->icao?>)</h1>
    </div>
    <div class="row">
        <?=\yii\bootstrap\Html::a('View '.$actother.' <i class="fa fa-forward"></i>',['/booking/'.$actother,'id'=>$model->airport_id])?>
    </div>
    <div class='row'>
        <?php
        echo \yii\grid\GridView::widget([
            'dataProvider'=>$dataProvider,
            'tableOptions'=>['class'=>'table table-striped'],
            'layout' => '{items}',
            'columns'=>[
                ['attribute'=>'airline','format'=>'html','header'=>false,'value'=>function($data){return \yii\bootstrap\Html::img('https://ivaoru.org/images/airlines/'.$data->airline.'.gif');}],
                ['attribute'=>'flightnumber','value'=>function($data){return $data->airline.$data->flightnumber;}],
                'gate',
                'aircraft',
                'icaofrom',
                'icaoto',
                'timefrom',
                'timeto',
                ['header'=>'info','format'=>'html','value'=>function($data){return \yii\helpers\Html::a('Book',\yii\helpers\Url::to(['/booking/book','id'=>$data->id]),['class'=>'btn btn-xs btn-success']);}]
            ]
        ]);
        ?>
    </div>

</div>
