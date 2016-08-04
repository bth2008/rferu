<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <!-- Custom styles for our template -->
    <link rel="stylesheet" href="/assets/css/main.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
	<script src="/assets/js/html5shiv.js"></script>
	<script src="/assets/js/respond.min.js"></script>
    <![endif]-->
	<?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <link rel="stylesheet" href="/assets/css/bootstrap-theme.css" media="screen" >

</head>
<body>
<?php $this->beginBody() ?>
<?php
yii\bootstrap\Dropdown::widget();
?>
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom">
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="/"><?=Yii::$app->name?></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li class="active"><a href="/">Home</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Briefing<b class="caret"></b></a>
						<ul class="dropdown-menu">
<?php
foreach(Yii::$app->params['languages'] as $lng=>$lname):
?>
							<li><a href="/briefing/<?=$lng?>"><?=$lname?></a></li>
<?php
endforeach;
?>
						</ul>
					</li>
					<li><a href="/booking" style="text-decoration: underline;" id="blinkbook">Book your flight</a></li>
					<li><a href="/stats">General statistics</a></li>
					<?=(Yii::$app->user->isGuest)?'<li><a class="btn" href="/site/login">LOGIN</a></li>':'<li><a class="btn" href="/site/logout">LOGOUT</a></li>'?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->
	<div class="content">
		<?=$content?>
	</div>
	<footer id="footer" class="top-space">
		<div class="footer1">
			<div class="container">
				<div class="row">
					
					<div class="col-md-3 widget">
						<h3 class="widget-title">Contact</h3>
						<div class="widget-body">
							<p>
								<a href="mailto:<?=Yii::$app->params['adminEmail']?>"><?=Yii::$app->params['adminEmail']?></a><br>
							</p>	
						</div>
					</div>
					<div class="col-md-3 widget">
						<h3 class="widget-title">Follow us</h3>
						<div class="widget-body">
							<p class="follow-me-icons">
								<a href="<?=Yii::$app->params['twitterLink']?>"><i class="fa fa-twitter fa-2"></i></a>
								<a href="<?=Yii::$app->params['fbLink']?>"><i class="fa fa-facebook fa-2"></i></a>
								<a href="<?=Yii::$app->params['vkLink']?>"><i class="fa fa-vk fa-2"></i></a>
								<a href="<?=Yii::$app->params['divisionSite']?>"><i class="fa fa-link fa-2"></i></a>
							</p>	
						</div>
					</div>
				</div> <!-- /row of widgets -->
			</div>
		</div>
		<div class="footer2">
			<div class="container">
				<div class="row">

					<div class="col-md-12 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2015-<?=date('Y')?>, IVAO RU-STAFF. Designed by <a href="http://gettemplate.com/" rel="designer">Progressus</a>
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

	</footer>	
		




	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="/assets/js/headroom.min.js"></script>
	<script src="/assets/js/jQuery.headroom.min.js"></script>
	<script src="/assets/js/template.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>