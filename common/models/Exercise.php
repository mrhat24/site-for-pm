<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exercise".
 *
 * @property integer $id
 * @property integer $author
 * @property string $text
 * @property integer $task
 * @property integer $subject
 */
class Exercise extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exercise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'subject_id', 'name'], 'required'],
            [['teacher_id', 'subject_id'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher_id' => 'Преподаватель',
            'text' => 'Текст',
            'subject_id' => 'Категория',
            'name' => 'Название'
        ];
    }
    
    /**
     * @get subject
     */
    public function getSubject()
    {
        return $this->hasOne(ExerciseSubject::className(),['id' => 'subject_id']);
    }
    
    /**
     * @get teacher
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(),['id' => 'teacher_id']);
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
