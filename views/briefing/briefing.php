<?php
//$language;
use yii\helpers\Html;
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class='row'>
    <?=$model->body?>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
        echo "<BR>".Html::a(Html::button('Edit page',['class'=>'btn btn-success']),'/site/editcontent?id='.$model->id);
    }?>
    </div>

</div>