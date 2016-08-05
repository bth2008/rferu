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
                <label class="control-label" for="batch-loading">Batch loading(CSV):</label>
                <input class="form-control-static" type="file" name="batch_loading" id="batch-loading" style="width: 300px;">
                <input type="submit">
            </div>

        </form>
    </div>
    <?php
    }
    ?>


</div>
