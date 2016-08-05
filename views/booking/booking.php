<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 04.08.16
 * Time: 15:15
 */
use app\assets\AptEditAsset;

$airports = $model->dataprovider->getModels();
$acnt = sizeof($airports);
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
    \yii\bootstrap\Modal::begin([
        'id' => 'admin_airport_edit_modal'
    ]);
    $form = \kartik\form\ActiveForm::begin(['type' => 'horizontal']);
    echo $form->field($model, 'name');
    echo $form->field($model, 'icao');
    echo \yii\helpers\Html::activeHiddenInput($model, 'id');
    echo \yii\bootstrap\Html::submitButton('Save', ['class' => 'btn btn-success']);
    \kartik\form\ActiveForm::end();
    \yii\bootstrap\Modal::end();
    AptEditAsset::register($this);
}
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class='row'>
        <?php
        foreach ($airports as $airport) { ?>
            <div class="col-lg-<?= floor(12 / $acnt) ?>">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="text-center"><?= $airport->name ?> (<?= $airport->icao ?>)
                            <?php
                            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
                                ?>
                                <i class="fa fa-remove pull-right" style="cursor: pointer"
                                   onclick="removeApt(<?= $airport->id ?>)"></i>
                                <i class="fa fa-pencil pull-right" style="cursor: pointer"
                                   onclick="editApt(<?= $airport->id ?>)"></i>
                                <?php
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="panel-body">
                        <?= \yii\bootstrap\Html::a('<i class="fa fa-plane fa-rotate-90"></i> Arrivals',
                            \yii\helpers\Url::to(['/booking/arrivals/', 'id' => $airport->id]),
                            ['class' => 'btn btn-lg btn-block btn-warning', 'style' => 'font-size: 20pt;'])
                        ?>
                        <hr/>
                        <?= \yii\bootstrap\Html::a('<i class="fa fa-plane"></i> Departures',
                            \yii\helpers\Url::to(['/booking/departures/', 'id' => $airport->id]),
                            ['class' => 'btn btn-lg btn-block btn-warning', 'style' => 'font-size: 20pt;'])
                        ?>
                        <hr/>
                        <?= \yii\bootstrap\Html::a('<i class="fa fa-paper-plane"></i> Charter Slots',
                            \yii\helpers\Url::to(['/booking/slots/', 'id' => $airport->id]),
                            ['class' => 'btn btn-lg btn-block btn-warning', 'style' => 'font-size: 20pt;'])
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isadmin) {
        ?>
        <div class="row text-center">
            <a href="javascript:null" onclick="addApt()" class="btn btn-lg btn-success"><i class="fa fa-plus"></i> Add airport</a>
        </div>
        <?php
    }
    ?>
</div>
