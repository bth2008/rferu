<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 08.08.16
 * Time: 16:53
 */
use kartik\form\ActiveForm;
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class="row">
        <h1 class="text-center">Booking private slot in <?=$model->airport->name?>(<?=$model->airport->icao?>) on <?=$model->timeslot?></h1>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
            ]);
            echo $form->field($model,'icaoto')->textInput();
            echo $form->field($model,'is_arrival')->checkbox();
            echo \yii\bootstrap\Html::submitButton('Reserve',['class'=>'btn btn-success']);
            ActiveForm::end();
            ?>
            </div>
        </div>

    </div>
</div>