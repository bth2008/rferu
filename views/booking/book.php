<?php
/**
 * Created by PhpStorm.
 * User: BTH
 * Date: 08.08.16
 * Time: 0:22
 */
$r = $model->turn?6:12;
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class="row">
        <h1 class="text-center">Booking confirmation</h1>
    </div>
    <div class="row">
        <?php
        for($i = $r; $i<=12; $i+=6):
        ?>
        <div class="col-lg-<?=$r?>" style="padding: 2%;">
            <div class="row panel panel-default">
                <div class="panel-heading">
                    <?=($i==$r or $r==12)?'Flight to book':'Turnaround flight'?>
                </div>
                <div class="panel-body">
                    <?php
                    $m=($i==$r or $r==12)?$model:$model->turn;
                    echo \yii\widgets\DetailView::widget([
                        'model'=>$m,
                        'attributes'=>[
                            ['label'=>'Flight Number','value'=>$m->airline.$m->flightnumber],
                            'aircraft',
                            'gate',
                            'icaofrom',
                            'icaoto',
                            'timefrom',
                            'timeto',

                        ]
                    ]);
                    echo \yii\helpers\Html::a(($i==$r or $r==12)?'Book only this flight':'Book both flights (main and turnaround)',
                        \yii\helpers\Url::to(['/booking/book-confirm', 'id'=>$model->id,'withta'=>($i==$r or $r==12)?0:1]),
                        ['class'=>'btn btn-success text-center btn-block']);
                    ?>
                </div>
            </div>
        </div>
        <?php
        endfor;
        ?>
    </div>
</div>