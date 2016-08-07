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
}
