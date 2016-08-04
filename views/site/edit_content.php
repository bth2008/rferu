<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 14.01.16
 * Time: 22:07
 */
use vova07\imperavi\Widget;
use \kartik\widgets\ActiveForm;
$form = ActiveForm::begin();
?>
<div style="height: 100px; display: block;"></div>
<div class="container">
<b>You are editting the <?=$model->language?> version of <?=$model->name?> file</b>
<hr>
<?php
echo $form->field($model, 'body')->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
        'plugins' => [
            'clips',
            'fullscreen'
        ]
    ]
]);
echo \yii\helpers\Html::submitButton('Save',['class'=>'btn btn-success']);
ActiveForm::end();
?>
</div>
