<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "airports".
 *
 * @property integer $id
 * @property string $icao
 * @property string $name
 */
class Airports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'airports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['icao'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icao' => 'ICAO',
            'name' => 'Name',
        ];
    }

    public function getDataprovider()
    {
        return new ActiveDataProvider([
               'query' => $this->find(),
            ]);
    }
}
