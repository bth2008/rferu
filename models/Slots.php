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
            [['timeslot','icaoto'],'required'],
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
