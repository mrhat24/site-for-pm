<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "standart".
 *
 * @property integer $id
 * @property string $name
 * @property string $start_date
 */
class Standart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'standart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start_date','key'], 'required'],
            [['start_date'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['key'],'number'],
            //[['key'], 'string', 'min' => 6,'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'name' => 'Название',
            'start_date' => 'Дата начала действия',
            'key' => 'Код'
        ];
    }
}
