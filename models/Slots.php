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
            [['timeslot'], 'safe'],
            [['airport_id', 'vid'], 'integer'],
            [['icaoto'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icaoto' => 'Icaoto',
            'timeslot' => 'Timeslot',
            'airport_id' => 'Airport ID',
            'vid' => 'Vid',
        ];
    }
}
