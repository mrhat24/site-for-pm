<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exercise_test".
 *
 * @property integer $id
 * @property integer $exercise_id
 * @property string $value
 * @property integer $istrue
 */
class ExerciseTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exercise_test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['exercise_id', 'value', 'istrue'], 'required'],
            [['exercise_id', 'istrue'], 'integer'],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'exercise_id' => 'Exercise ID',
            'value' => 'Текст',
            'istrue' => 'is true',
        ];
    }
    
    public function getExercise()
    {
        return $this->hasOne(Exercise::className(),['id' => 'exercise_id']);
    }
}
