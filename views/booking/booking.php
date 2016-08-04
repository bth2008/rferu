<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 04.08.16
 * Time: 15:15
 */
\yii\helpers\VarDumper::dump($model->dataprovider->getModels(),10,true);

\yii\helpers\VarDumper::dump(Yii::$app->user->identity);