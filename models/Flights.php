<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "flights".
 *
 * @property integer $id
 * @property string $icaofrom
 * @property string $icaoto
 * @property string $timefrom
 * @property string $timeto
 * @property string $airline
 * @property integer $flightnumber
 * @property integer $airport_id
 * @property integer $isarrival
 * @property integer $gate
 * @property integer $vid
 * @property integer $turnaround_id
 */
class Flights extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flights';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timefrom', 'timeto','aircraft'], 'safe'],
            [['flightnumber', 'airport_id', 'isarrival', 'gate', 'vid', 'turnaround_id'], 'integer'],
            [['icaofrom', 'icaoto', 'airline'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icaofrom' => 'From',
            'icaoto' => 'To',
            'timefrom' => 'Departure',
            'timeto' => 'Arrival',
            'airline' => 'Airline',
            'flightnumber' => 'Flight',
            'airport_id' => 'Airport ID',
            'isarrival' => 'Isarrival',
            'gate' => 'Gate',
            'vid' => 'Vid',
            'turnaround_id' => 'Turnaround ID',
        ];
    }
    public function getAirport(){
        return $this->hasOne(Airports::className(),['id'=>'airport_id']);
    }
    public function getTurn()
    {
        return $this->turnaround_id?$this->hasOne(Flights::className(),['id'=>'turnaround_id']):null;
    }
    public function getPilot()
    {
        return $this->hasOne(Users::className(),['vid'=>'vid']);
    }
    public function getDataprovider()
    {
        $query = new ActiveQuery($this::className());
        if($this->airport_id) $query->andWhere(['airport_id'=>$this->airport_id]);
        $query->andWhere(['isarrival'=>$this->isarrival]);
        $query->orderBy(($this->isarrival == 1)?"timeto":"timefrom");
        return new ActiveDataProvider([
            'query'=> $query
        ]);
    }
    public function renderBP()
    {
        $image = imagecreatefrompng(dirname(__FILE__).'/../web/assets/images/template.png');
        $font = dirname(__FILE__).'/../web/assets/fonts/courbd.ttf';
        $black_color = imagecolorallocate($image, 0x00, 0x00, 0x00);
        $red_color = imagecolorallocate($image, 0xFF, 0x00, 0x00);
        $white_color = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);

        imagettftext($image, 35, 0, 50, 60, $red_color, $font, Yii::$app->name);

        imagettftext($image, 30, 0, 130, 125, $black_color, $font, date('H:i', strtotime($this->timefrom)-30*60));
        imagettftext($image, 30, 0, 300, 125, $black_color, $font, Yii::$app->params['event_date']);
        imagettftext($image, 30, 0, 735, 180, $black_color, $font, date('H:i', strtotime($this->timefrom)));
        imagettftext($image, 30, 0, 340, 205, $black_color, $font, $this->icaofrom);
        imagettftext($image, 30, 0, 520, 205, $black_color, $font, $this->icaoto);
        imagettftext($image, 30, 0, 690, 325, $white_color, $font, $this->airline.$this->flightnumber);

        imagettftext($image, 23, 0, 50, 300, $white_color, $font, $this->airline.$this->flightnumber);
        imagettftext($image, 23, 0, 200, 300, $white_color, $font, $this->gate);
        imagettftext($image, 23, 0, 310, 300, $white_color, $font, date('H:i', strtotime($this->timefrom)));
        imagettftext($image, 20, 0, 680, 255, $black_color, $font, $this->icaofrom);
        imagettftext($image, 20, 0, 780, 255, $black_color, $font, $this->icaoto);
        imagettftext($image, 17, 0, 50, 185, $black_color, $font, substr(strtoupper($this->pilot->firstname.' '.$this->pilot->lastname), 0, 21));
        imagettftext($image, 15, 0, 675, 112, $black_color, $font, strtoupper($this->pilot->firstname));
        imagettftext($image, 15, 0, 675, 132, $black_color, $font, strtoupper($this->pilot->lastname));

        imagettftext($image, 15, 0, 421, 237, $black_color, $font, substr($this->icaofrom, 0, 20));
        imagettftext($image, 15, 0, 421, 260, $black_color, $font, substr($this->icaoto, 0, 20));
        imagettftext($image, 10, 0, 558, 340, $black_color, $font, $this->airline);

        $otffont = dirname(__FILE__).'/../web/assets/fonts/bc.otf';
        imagettftext($image, 12, 0, 430, 315, $black_color, $otffont, '*'.$this->airline.$this->flightnumber.'/'.$this->id.'*');

        //imagegif($image, Yii::app()->getBasePath().'/images/boardingpass/f'.$booking.'.png');
        header("Content-Type: image/png");
        imagepng($image);
    }
}
