<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_history".
 *
 * @property integer $id
 * @property integer $work_id
 * @property string $name
 * @property integer $creation_date
 */
class WorkHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_id', 'name', 'creation_date'], 'required'],
            [['work_id', 'creation_date'], 'integer'],
            [['name'],'trim'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_id' => 'id работы',
            'name' => 'Название',
            'creation_date' => 'Дата создания',
            'teacher_id' => 'Преподаватель'
        ];
    }
    
}
