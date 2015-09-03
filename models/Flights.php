<?php

namespace app\models;

use Yii;

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
            [['timefrom', 'timeto'], 'safe'],
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
            'icaofrom' => 'Icaofrom',
            'icaoto' => 'Icaoto',
            'timefrom' => 'Timefrom',
            'timeto' => 'Timeto',
            'airline' => 'Airline',
            'flightnumber' => 'Flightnumber',
            'airport_id' => 'Airport ID',
            'isarrival' => 'Isarrival',
            'gate' => 'Gate',
            'vid' => 'Vid',
            'turnaround_id' => 'Turnaround ID',
        ];
    }
}
