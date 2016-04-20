<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "teacher_has_discipline".
 *
 * @property integer $id
 * @property integer $teacher_id
 * @property integer $ghd_id
 * @property integer $begin_date
 * @property integer $end_date
 */
class TeacherHasDiscipline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher_has_discipline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_id', 'ghd_id', 'begin_date', 'end_date'], 'required'],
            [['teacher_id', 'ghd_id', 'begin_date', 'end_date'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher_id' => 'Teacher ID',
            'ghd_id' => 'Ghd ID',
            'begin_date' => 'Begin Date',
            'end_date' => 'End Date',
        ];
    }
    
    /*
     * get teacher
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(),['id' => 'teacher_id']);
    }
    
    /*
     * get ghd
     */
    public function getGroupHasDiscipline()
    {
        return $this->hasOne(GroupHasDiscipline::className(),['id' => 'ghd_id']);
    }
    
    public function getLessons()
    {
        return $this->hasMany(Lesson::className(),['thd_id' => 'id']);
    }
}