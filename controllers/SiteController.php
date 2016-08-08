<?php

namespace app\controllers;

use app\models\Airports;
use app\models\ContactForm;
use app\models\Content;
use app\models\Flights;
use app\models\User;
use Yii;
use yii\base\Exception;
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
        if ($action->id != 'install') {
            try{
                !Yii::$app->db->createCommand("SHOW tables")->queryAll();
            }
            catch(Exception $e) {
                $this->redirect(Url::to('/site/install'));
                return false;
            }
        }
        return true;
    }

    public function actionIndex()
    {
        $bl = Content::find()->andWhere('name = "bannerLabel"')->one();
        $bd = Content::find()->andWhere('name = "homePage"')->one();
        return $this->render('index', ['bl' => $bl, 'bd' => $bd]);
    }

    public function actionInstall()
    {
        if(Yii::$app->params['installed'] === false):
        Yii::$app->db->createCommand("
	        DROP TABLE IF EXISTS users; CREATE TABLE users(vid INT NOT NULL PRIMARY KEY,firstname VARCHAR(100),lastname VARCHAR(100),country VARCHAR(5),division VARCHAR(5), pilot_rating INT) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
	        DROP TABLE IF EXISTS flights; CREATE TABLE flights(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,aircraft VARCHAR(10), icaofrom VARCHAR(5), icaoto VARCHAR(5), timefrom TIME, timeto TIME, airline VARCHAR(5),flightnumber INT, airport_id INT, isarrival INT, gate INT, vid INT, turnaround_id INT) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
	        DROP TABLE IF EXISTS slots; CREATE TABLE slots(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, icaoto VARCHAR(5), timeslot TIME, airport_id INT, vid INT, is_arrival INT) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
	        DROP TABLE IF EXISTS airports; CREATE TABLE airports(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, icao VARCHAR(5), name VARCHAR(200)) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
	        DROP TABLE IF EXISTS content; CREATE TABLE content(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(200), body TEXT, language VARCHAR(10)) DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
	    ")->execute();
        Yii::$app->db->createCommand("
	        INSERT INTO content(name,body,language) VALUES('homePage','Home Page content in HTML.<br>Use redactor to edit this',NULL),('bannerLabel','Just installed',NULL);
	    ")->execute();
        foreach (Yii::$app->params['languages'] as $lng => $langname) {
            Yii::$app->db->createCommand("
		        INSERT INTO content(name,body,language) VALUES('briefing','HTML Briefing in $lng language.<br>Use redactor to edit this','$lng');
	        ")->execute();
        }
        endif;
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
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this->refresh();
        }
        return $this->render('edit_content', ['model' => $model]);
    }

    public function actionGetAptData()
    {
        $id = Yii::$app->request->post('id');
        $airport = Airports::findOne($id)->toArray();
        return json_encode($airport);
    }

    public function actionRemoveApt()
    {
        $id = Yii::$app->request->post('id');
        foreach (Flights::find()->andWhere(['airport_id' => $id])->all() as $flight)
            $flight->delete();
        $apt = Airports::findOne($id);
        $apt->delete();
    }
    public function actionGetTurnaroundCandidates()
    {
        $id = Yii::$app->request->post('id');
        $ownflight = Flights::findOne($id);
        $candidates = Flights::find()
            ->andWhere(['airline'=>$ownflight->airline])
            ->andWhere(['icaofrom'=>$ownflight->icaoto])
            ->andWhere(['icaoto'=>$ownflight->icaofrom])
            ->andWhere(['turnaround_id'=>null])
            ->asArray()->all();
        echo json_encode($candidates);
    }
    public function actionUnlinkturnaround()
    {
        $id = Yii::$app->request->post('id');
        $f = Flights::findOne($id);
        $t = $f->turn;
        $t->turnaround_id = null;
        $f->turnaround_id = null;
        $t->save();
        $f->save();
    }
    public function actionGettrnflight()
    {
        $id = Yii::$app->request->post('id');
        $f = Flights::find()->andWhere(['turnaround_id'=>$id])->asArray()->one();
        echo json_encode($f);
    }
}
