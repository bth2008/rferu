<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 08.08.16
 * Time: 15:45
 */
use kartik\time\TimePicker;
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class="row">
        <h1 class="text-center"><?=$model->airport->name?> private slots (<?=$model->airport->icao?>) </h1>
    </div>
    <div class="row">
        <?php
        echo \yii\grid\GridView::widget([
            'dataProvider'=>$dataProvider,
            'tableOptions'=>['class'=>'table table-striped'],
            'layout' => '{items}',
            'columns'=>[
                'timeslot',
                ['attribute'=>'vid','format'=>'html','header'=>'Info','value'=>function($data){
                    return($data->vid)?
                        \yii\helpers\Html::a('Booked by '.$data->vid,\yii\helpers\Url::to(['/booking/showslotinfo/','id'=>$data->id]),['class'=>'btn btn-danger']):
                        \yii\helpers\Html::a('Book',\yii\helpers\Url::to(['/booking/bookslot','id'=>$data->id]),['class'=>'btn btn-success']);
                }]
            ]
        ]);
        ?>
    </div>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin){?>
    <div class="row">
        <?php
        $form = \kartik\form\ActiveForm::begin(['type'=>'inline']);
        echo $form->field($model,'timeslot')->widget(TimePicker::className(),['pluginOptions'=>['showMeridian'=>false]]);
        echo " ";
        echo \yii\bootstrap\Html::submitButton('<i class="fa fa-check"></i>Add',['class'=>'btn btn-success btn-sm']);
        \kartik\form\ActiveForm::end();
        ?>
    </div>
    <?php } ?>
</div>
