<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slots".
 *
 * @property integer $id
 * @property string $icaoto
 * @property string $timeslot
 * @property integer $airport_id
 * @property integer $vid
 */
class Slots extends \yii\db\ActiveRecord
{
    const SCENARIO_RESERVE = 'reserve';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_RESERVE] = ['vid', 'icaoto', 'timeslot'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slots';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timeslot'],'required'],
            [['timeslot','icaoto'],'required','on' => self::SCENARIO_RESERVE],
            [['timeslot'], 'safe'],
            [['airport_id', 'vid','is_arrival'], 'integer'],
            [['icaoto'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icaoto' => 'The ICAO code of second airport',
            'timeslot' => 'Timeslot',
            'airport_id' => 'Airport ID',
            'vid' => 'Vid',
            'is_arrival' => 'Reserve this slot for arrival',
        ];
    }

    public function getAirport(){
        return $this->hasOne(Airports::className(),['id'=>'airport_id']);
    }
}
