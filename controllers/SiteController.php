<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\Content;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;

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
        if (!Yii::$app->db->createCommand("SHOW tables")->queryAll() && $action->id != 'install') {
            $this->redirect(Url::to('/site/install'));
            return false;
        }
        return true;
    }

    public function actionIndex()
    {
        $bl = Content::find()->andWhere('name = "bannerLabel"')->one();
        $bd = Content::find()->andWhere('name = "homePage"')->one();
        return $this->render('index',['bl'=>$bl,'bd'=>$bd]);
    }

    public function actionInstall()
    {
        Yii::$app->db->createCommand("
	    CREATE TABLE users(vid INT NOT NULL PRIMARY KEY,firstname VARCHAR(100),lastname VARCHAR(100),country VARCHAR(5),division VARCHAR(5), pilot_rating INT);
	    CREATE TABLE flights(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, icaofrom VARCHAR(5), icaoto VARCHAR(5), timefrom TIME, timeto TIME, airline VARCHAR(5),flightnumber INT, airport_id INT, isarrival INT, gate INT, vid INT, turnaround_id INT);
	    CREATE TABLE slots(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, icaoto VARCHAR(5), timeslot TIME, airport_id INT, vid INT);
	    CREATE TABLE airports(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, icao VARCHAR(5), name VARCHAR(200));
	    CREATE TABLE content(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(200), body TEXT, language VARCHAR(10));
	")->execute();
        Yii::$app->db->createCommand("
	    INSERT INTO content(name,body,language) VALUES('homePage','Home Page content in HTML.<br>Use redactor to edit this',NULL),('bannerLabel','Just installed',NULL);
	")->execute();
        foreach (Yii::$app->params['languages'] as $lng => $langname) {
            Yii::$app->db->createCommand("
		INSERT INTO content(name,body,language) VALUES('briefing','HTML Briefing in $lng language.<br>Use redactor to edit this','$lng');
	    ")->execute();
        }
        return $this->render('install');
    }

    public function actionLogin($IVAOTOKEN = null)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (!$IVAOTOKEN) {
            return $this->redirect(Yii::$app->params['api_url']);
        }
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

    public function actionEditcontent($id)
    {
        $model = Content::findOne($id);
        if($model->load(Yii::$app->request->post()))
        {
            $model->save();
            $this->refresh();
        }
        return $this->render('edit_content',['model'=>$model]);
    }
}
