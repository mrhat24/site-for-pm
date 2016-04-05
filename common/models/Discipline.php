<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discipline".
 *
 * @property integer $id
 * @property string $name
 */
class Discipline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discipline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150]
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
        ];
    }
    
    /**
     * @get grops has discipline
     */
    public function getGroupHasDisciplines()
    {
        return $this->hasMany(GroupHasDiscipline::className(),['discipline_id' => 'id']);
    }
}
