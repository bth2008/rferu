<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action)
    {
	if(!Yii::$app->db->createCommand("SHOW tables")->queryAll() && $action->id!='install'){
	    $this->redirect(Url::to('/site/install'));
	    return false;
	}
	return true;
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionInstall()
    {
	Yii::$app->db->createCommand("
	    CREATE TABLE users(vid int not null primary key,firstname varchar(100),lastname varchar(100),country varchar(5),division varchar(5), pilot_rating int);
	    CREATE TABLE flights(id int not null primary key auto_increment, icaofrom varchar(5), icaoto varchar(5), timefrom time, timeto time, airline varchar(5),flightnumber int, airport_id int, isarrival int, gate int, vid int, turnaround_id int);
	    CREATE TABLE slots(id int not null primary key auto_increment, icaoto varchar(5), timeslot time, airport_id int, vid int);
	    CREATE TABLE airports(id int not null primary key auto_increment, icao varchar(5), name varchar(200));
	    CREATE TABLE content(id int not null primary key auto_increment, name varchar(200), body text, language varchar(10));
	")->execute();
	Yii::$app->db->createCommand("
	    INSERT INTO content(name,body,language) VALUES('homePage','Home Page content in HTML.<br>Use redactor to edit this',NULL),('bannerLabel','Just installed',NULL);
	")->execute();
	foreach(Yii::$app->params['languages'] as $lng=>$langname){
	    Yii::$app->db->createCommand("
		INSERT INTO content(name,body,language) VALUES('briefing','HTML Briefing in $lng language.<br>Use redactor to edit this','$lng');
	    ")->execute();
	}
	return $this->render('install');
    }
    public function actionLogin($IVAOTOKEN=null)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
	if(!$IVAOTOKEN)
	    return $this->redirect(Yii::$app->params['api_url']);
	//have the token
	$model = new User;
	$model->login($IVAOTOKEN);
	$this->redirect(Yii::$app->user->returnUrl);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
