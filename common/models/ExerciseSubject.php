<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exercise_subject".
 *
 * @property integer $id
 * @property string $name
 * @property integer $author
 */
class ExerciseSubject extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exercise_subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['teacher_id'], 'integer'],
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
            'teacher_id' => 'Преподаватель',
        ];
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
