<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "given_exercise_test_answers".
 *
 * @property integer $id
 * @property integer $given_exercise_id
 * @property integer $exercise_test_id
 */
class GivenExerciseTestAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'given_exercise_test_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['given_exercise_id', 'exercise_test_id'], 'required'],
            [['given_exercise_id', 'exercise_test_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'given_exercise_id' => 'Given Exercise ID',
            'exercise_test_id' => 'Exercise Test ID',
        ];
    }
}
