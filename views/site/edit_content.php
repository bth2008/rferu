<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 14.01.16
 * Time: 22:07
 */
//use vova07\imperavi\Widget;
use \kartik\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
$form = ActiveForm::begin();
?>
<div style="height: 100px; display: block;"></div>
<div class="container">
<b>You are editting the <?=$model->language?> version of <?=$model->name?> file</b>
<hr>
<?php
echo $form->field($model, 'body')->widget(TinyMce::className(), [
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'plugins' => [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        'toolbar1'=> 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        'toolbar2'=> 'print preview media | forecolor backcolor emoticons fontsizeselect fontselect',
    ]
]);
echo \yii\helpers\Html::submitButton('Save',['class'=>'btn btn-success']);
ActiveForm::end();
?>
</div>
