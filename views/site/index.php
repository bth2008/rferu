<?php

/* @var $this yii\web\View */
use app\models\Content;
$this->title = Yii::$app->name." - Home";
?>
<header id='head'>
	<div class='container'>
		<div class="row">
		    <?=Content::find()->andWhere('name = "bannerLabel"')->one()->body;?>
		</div>
	</div>
</header>
<section id="features">
	<div class="container">
	    <div class="row">
		<?=Content::find()->andWhere('name = "homePage"')->one()->body;?>
	    </div>
	</div>
</section>


