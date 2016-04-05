<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property string $name
 * @property integer $author
 * @property integer $type_id
 * @property string $text
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'teacher_id', 'type_id', 'text'], 'required'],
            [['teacher_id', 'type_id'], 'integer'],
            [['text'], 'string'],
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
            'name' => 'Название',
            'author' => 'Автор',
            'type_id' => 'Тип',
            'text' => 'Текст',
        ];
    }
    
    /**
     * @get given tasks
     */
    public function getGivenTasks()
    {
        return $this->hasMany(GivenTask::className(),['task_id' => 'id']);
    }      
    
    /**
     * @get author
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(),['id' => 'teacher_id']);
    }  
    
    /**
     * @get task type
     */
    public function getTaskType()
    {
        return $this->hasOne(TaskType::className(),['id' => 'type_id']);
    }  
    
}
