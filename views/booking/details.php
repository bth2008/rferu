<?php
/**
 * Created by PhpStorm.
 * User: bth
 * Date: 08.08.16
 * Time: 10:52
 */
?>
<div class="container" style="padding-top: 100px; min-height: 100%;">
    <div class="row">
        <img src="/booking/boardingpass/<?=$model->id?>" />
    </div>
    <hr>
    <div class="row">
        <a href="/booking/cancel/<?=$model->id?>" class="btn btn-block btn-danger text-center"><i class="fa fa-trash-o"></i> Cancel booking</a>
    </div>
</div>
