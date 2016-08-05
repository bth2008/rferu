<?php
?>
<div class='container' style='padding-top: 100px;'>
<div class="row">
    <h1 class="text-center">Hi, dear IVAO RFE/MSE administrator!</h1>
    <div class="well">
        <p>
            To install this software, you should follow this steps:
        </p>
        <ul>
            <li>At first - you have to create database named <b>"rfe"</b> or any other name on your choice in your MySQL server;
                <pre style="background-color: white;">CREATE DATABASE rfe;</pre>
            </li>
            <li>
                Then create file <b>"config/db.php"</b> and fill it as example below:
                <pre style="background-color: white;">
&lt;?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=<b>your_host_name</b>; dbname=<b>rfe</b>',
    'username' => <b>'YOUR USERNAME HERE'</b>,
    'password' => <b>'YOUR PASSWORD HERE'</b>,
    'charset' => 'utf8',
];
?&gt;
                </pre>
            </li>
            <li>
                At next - go to <b>"config/params.php"</b> and fill all parameters as you whish, e.g.
                <pre style="background-color: white">
                    'adminEmail' => 'ru-staff@ivao.aero',
                    'twitterLink' => '', //<-- this is the link to your division twitter account, leave it blank if you don't use it
                    'fbLink' => '', //<-- this is the link to your division facebook account, leave it blank if you don't use it
                    'vkLink' => '', //<-- this is the link to your division Vkontakte account, leave it blank if you don't use it
                    'divisionSite' => '' //<-- this is the link to your division site, leave it blank if you don't use it
                    'adminsvids' => [11111,00000], //<-- the list of administator's VID's. It's mandatory to fill at least one VID
                    'languages' => ['ru'=>'Русский','en'=>'English'], //<-- list of available briefing languages, you can configure it as you wish. Change this before install
                    'api_url' => 'https://login.ivao.aero/index.php?url=<b>http://URL_OF_YOUR_RFE_SITE</b>/site/login', //<--change to your http(s) host. Ensure the IVAO LOGIN API is available for your domain.
                    'installed' => true, //<-- change to false. It's mandatory to proceed install
                </pre>
            </li>
            <li>
                Just <b>update this page</b>
            </li>
            <li>
                <?php
                try{
                    $p = \app\models\Content::findOne(1);
                    if(!empty($p))
                    {
                        ?>
                        <b style="color: green">Congratulations! You just install the RFE/MSE software.</b><br>
                        Don't forget to change <b>installed</b> parameter to <b>true</b> in <b>"config/params.php"</b>
                        <?php
                    }
                } catch(\yii\base\Exception $e){
                    if(Yii::$app->params['installed'] === false)
                    {
                        echo "Something wrong... I realy do not understand this";
                    }
                    else{
                        echo "Installation can not continue due to installed parameter setted to true";
                    }
                }
                ?>
            </li>
        </ul>
    </div>
</div>

</div>