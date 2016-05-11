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
    public static $types = [1 => 'Текст', 2 => 'Тест'];    

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
            [['test'],'boolean'],
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
            'name' => 'Название',
            'textMd' => 'Текст',
            'type' => 'Тип',
            'exerciseTests' => 'Варианты ответов',
            'test' => 'Использовать варианты ответа',
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
     * @get subject
     */
    public function getTextMd()
    {
        return $this->text;
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
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            ExerciseTest::deleteAll(['exercise_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

    public function getExerciseTests()
    {
        return $this->hasMany(ExerciseTest::className(), ['exercise_id' => 'id']);
    }
    
    public function getExerciseTestsTrue()
    {
        $array = array();
        foreach ($this->exerciseTests as $et){
            if($et->istrue)
                $array[] = $et->id;
        }
        return $array;
    }
        
}
