<?php
return [
	'adminEmail' => 'ru-staff@ivao.aero',
	'twitterLink' => '',
	'fbLink' => '',
	'vkLink' => '',
	'divisionSite' => '',
	'languages' => ['en'=>'English','ru'=>'Russian'],
	'api_url' => 'https://login.ivao.aero?url='.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].'/site/login',
	'adminsvids' => [439914],
];
