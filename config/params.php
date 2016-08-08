<?php
$protocol = 'http';
$host = $_SERVER['HTTP_HOST'];
return [
    'adminEmail' => 'ru-staff@ivao.aero',
	'event_date' => '03.09.2016',
	'twitterLink' => '',
	'fbLink' => '',
	'vkLink' => '',
	'divisionSite' => '',
	'adminsvids' => [439914,350631,211774,334668,442121,472469],
    'languages' => ['ru'=>'Русский','en'=>'English'],
    'api_url' => 'https://login.ivao.aero/index.php?url='.$protocol.'://'.$host.'/site/login',
	'installed' => true,
];
