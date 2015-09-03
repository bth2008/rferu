<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $vid
 * @property string $firstname
 * @property string $lastname
 * @property string $country
 * @property string $division
 * @property integer $pilot_rating
 */
class Users extends \yii\db\ActiveRecord 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid'], 'required'],
            [['vid', 'pilot_rating'], 'integer'],
            [['firstname', 'lastname'], 'string', 'max' => 100],
            [['country', 'division'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vid' => 'Vid',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'country' => 'Country',
            'division' => 'Division',
            'pilot_rating' => 'Pilot Rating',
        ];
    }

}