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
\app\assets\BookingClientAsset::register($this);
if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin)
{
    \app\assets\BookingAsset::register($this);
    \yii\bootstrap\Modal::begin(['id'=>'linkturnaroundmodal']);
    ?>
    <form method="POST">
        <label for="turnarounds">Turnaround candidate:</label>
        <SELECT class='form-control' id='turnarounds' name="admin_link_turnaround"></SELECT> <hr/>
        <INPUT TYPE="hidden" id="ownid" name="admin_link_ownid" />
        <input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
               value="<?=Yii::$app->request->csrfToken?>"/>
        <?php
        echo \yii\helpers\Html::submitButton('Link',['class'=>'btn btn-success']);
        ?>
    </form>
    <?php
    \yii\bootstrap\Modal::end();
}
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
                ['attribute'=>'flightnumber','format'=>'raw','value'=>function($data){
                    $lnk = ($data->turnaround_id)?"<i onclick='showturnaround($data->id)' style='cursor: pointer;' class='fa fa-spin fa-refresh' title='This flight have turnaround'></i>":"";
                    return $lnk." ".$data->airline.$data->flightnumber;
                }],
                'gate',
                'aircraft',
                'icaofrom',
                'icaoto',
                'timefrom',
                'timeto',
                ['header'=>'info','format'=>'html','value'=>function($data){return \yii\helpers\Html::a('Book',\yii\helpers\Url::to(['/booking/book','id'=>$data->id]),['class'=>'btn btn-xs btn-success']);}],
                ['visible'=>!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin,
                    'class'=>\yii\grid\ActionColumn::className(),
                    'header'=>'Admin',
                    'template'=>'{turnaround} {delete}',
                    'buttons'=>[
                        'turnaround'=> function ($url, $model, $key) {
                            if(!$model->turnaround_id) {
                                return "<i style='cursor: pointer' onclick='linkturnaround($model->id)' title='link turnaround flights' class='fa fa-refresh'></i>";
                            }
                            else{
                                return "<i style='cursor: pointer' onclick='unlinkturnaround($model->id)' title='unlink turnaround flights' class='fa fa-unlink'></i>";
                            }
                        }
                    ]
                ],
            ]
        ]);
        ?>
    </div>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin){?>
    <div class="row">
        <?php
        $form = \kartik\form\ActiveForm::begin(['type'=>'inline']);
        echo $form->field($model,'airline')->textInput(['style'=>'width: 100px;']);
        echo $form->field($model,'flightnumber')->textInput(['style'=>'width: 100px;']);
        echo $form->field($model,'gate')->textInput(['style'=>'width: 100px;']);
        echo $form->field($model,'aircraft')->textInput(['style'=>'width: 100px;']);
        echo $form->field($model,'icaofrom')->textInput(['style'=>'width: 100px;','readonly'=>!$model->isarrival]);
        echo $form->field($model,'icaoto')->textInput(['style'=>'width: 100px;','readonly'=>($model->isarrival==1)]);
        echo $form->field($model,'timefrom')->textInput(['style'=>'width: 100px;']);
        echo $form->field($model,'timeto')->textInput(['style'=>'width: 100px;']);
        echo \yii\bootstrap\Html::submitButton('<i class="fa fa-check"></i>Add',['class'=>'btn btn-success btn-sm']);
        \kartik\form\ActiveForm::end();
        ?>
        <hr />
        <form method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group field-batch-loading">
                <input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
                       value="<?=Yii::$app->request->csrfToken?>"/>
                <label class="control-label" for="batch-loading">Batch loading(<?=\yii\helpers\Html::a("XLSX",\yii\helpers\Url::to(['/booking/export-'.strtolower($act),'id'=>$model->airport_id]))?>):</label>
                <input class="form-control-static" type="file" name="batch_loading" id="batch-loading" style="width: 300px;">
                <input type="submit">
            </div>

        </form>
    </div>
    <?php
    }
    ?>


</div>
