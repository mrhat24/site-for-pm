<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "given_exercise".
 *
 * @property integer $id
 * @property integer $exercise_id
 * @property integer $given_task_id
 * @property string $solution
 * @property integer $result
 * @property string $comment
 * @property integer $remake
 */
class GivenExercise extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'given_exercise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['exercise_id', 'given_task_id'], 'required'],
            [['exercise_id', 'given_task_id', 'result', 'remake'], 'integer'],
            [['solution', 'comment'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exercise_id' => 'Упражнение',
            'given_task_id' => 'Задание',
            'solution' => 'Решение',
            'result' => 'Результат',
            'comment' => 'Коментарий',
            'remake' => 'Переделать',
        ];
    }
    /*
     * @get exercise
     */
    public function getExercise()
    {
        return $this->hasOne(Exercise::className(),['id' => 'exercise_id']);
    }
    /*
     * @ get givenTask
     */
    public function getGivenTask()
    {
        return $this->hasOne(GivenTask::className(), ['id' => 'given_task_id']);
    }
}
