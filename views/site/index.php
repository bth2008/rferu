<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = Yii::$app->name . " - Home";
?>
<header id='head'>
    <div class='container'>
        <div class="row">
            <?= $bl->body; ?>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
                echo "" . Html::a('<i class="fa fa-pencil"></i>', '/site/editcontent?id=' . $bl->id);
            } ?>
        </div>
    </div>
</header>
<section id="features">
    <div class="container">
        <div class="row">
            <?= $bd->body; ?>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
                echo "<BR>" . Html::a(Html::button('Edit page', ['class' => 'btn btn-success']),
                        '/site/editcontent?id=' . $bd->id);
            } ?>
        </div>
    </div>
</section>


