<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "complete_exercise".
 *
 * @property integer $id
 * @property string $text
 * @property integer $date
 * @property integer $exercise_id
 * @property integer $given_task_id
 * @property integer $result
 * @property string $comment
 */
class CompleteExercise extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'complete_exercise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
            [['text', 'comment'], 'string'],
            [['date', 'exercise_id', 'given_task_id', 'result'], 'integer'],
            [['remake'],'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
            'date' => 'Дата',
            'exercise_id' => 'ID упражнения',
            'given_task_id' => 'ID выданного задания',
            'result' => 'Оценка',
            'comment' => 'Коментарий',
            'remake' => 'Переделать',
        ];
    }
    
    public function getExercise()
    {
        return $this->hasOne(Exercise::className(),['id' => 'exercise_id']);
    }
}
