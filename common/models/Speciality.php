<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "speciality".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $start_date
 * @property integer $standart_id
 */
class Speciality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'speciality';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'start_date', 'standart_id'], 'required'],
            [['start_date'], 'safe'],
            [['standart_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'code' => 'Код',
            'start_date' => 'Начало использования',
            'standart_id' => 'Стандарт',
        ];
    }
    
    /**
     * @get standart
     */
    public function getStandart()
    {
        return $this->hasOne(Standart::className(),['id' => 'standart_id']);
    }  
    
    /**
     * @get groups
     */
    public function getGroups()
    {
        return $this->hasMany(Group::className(),['speciality_id' => 'id']);
    }  
      
}
