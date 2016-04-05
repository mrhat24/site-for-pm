<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_type".
 *
 * @property integer $id
 * @property string $name
 */
class TaskType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['teacher_id'],'integer'],
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
            'teacher_id' => 'Преподаватель'
        ];
    }
    
    public static function typeList()
    {
        $taskTypes = TaskType::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all();
        $taskTypeList = array();
        foreach($taskTypes as $type)
        {
            $taskTypeList[$type->id] = $type->name;
        }
        return $taskTypeList;
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->teacher_id = Yii::$app->user->identity->teacher->id;

            return true;
        }
        return false;
    }
}
