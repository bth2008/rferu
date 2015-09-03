<?php
//$language;
use app\models\Content;
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class='row'>
    <?=Content::find()->andWhere('name="briefing"')->andWhere('language="'.$language.'"')->one()->body?>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) { echo "TOOL<BR>";}?>
    </div>

</div>