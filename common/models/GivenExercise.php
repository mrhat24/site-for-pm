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
    
    ///public $answers;
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
    
    public function getGivenExerciseTestAnswers()
    {
        return $this->hasMany(GivenExerciseTestAnswers::className(), ['given_exercise_id' => 'id']);
    }
    
    public function checkAndSetAnswers($arr)
    {
        $old_answers = $this->answers;
        $del_answers = array_diff($old_answers, $arr);
        $add_answers = array_diff($arr, $old_answers);
        foreach($del_answers as $answer) {
            $model = GivenExerciseTestAnswers::find()->where(['given_exercise_id' => $this->id])->andWhere(['exercise_test_id' => $answer])->one();
            $model->delete();
        }
        foreach($add_answers as $answer){
                $model2 = new GivenExerciseTestAnswers();
                $model2->given_exercise_id = $this->id;
                $model2->exercise_test_id = $answer;
                $model2->save();
        }
    }
    
    public function getAnswerIsTrue()
    {
        return !array_diff($this->answers,$this->exercise->exerciseTestsTrue);            
    }

    public function getAnswers()
    {
        return \yii\helpers\ArrayHelper::getColumn($this->givenExerciseTestAnswers, 'exercise_test_id');
    }


    /*
     * @ get givenTask
     */
    public function getGivenTask()
    {
        return $this->hasOne(GivenTask::className(), ['id' => 'given_task_id']);
    }
}
