<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "complete_task".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $given_task_id
 * @property string $text
 * @property integer $date
 * @property integer $result
 * @property string $comment
 */
class CompleteTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS = [['identity' => 'active'],['identity' => 'warning']]; 
    
    public static function tableName()
    {
        return 'complete_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['given_task_id'], 'required'],
            [['given_task_id', 'date', 'result'], 'integer'],
            [['comment'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'given_task_id' => 'ID выданного задания',            
            'date' => 'Дата',
            'result' => 'Результат',
            'comment' => 'Коментарий',            
        ];
    }
    
    /**
     * @get given task
     */
    public  function getGivenTask()
    {
        return $this->hasOne(GivenTask::className(),['id' => 'given_task_id']);
    }
    
    public function getCompleteExersices()
    {
        return $this->hasMany(CompleteExercise::className(),['given_task_id' => 'given_task_id']);
    }
}
