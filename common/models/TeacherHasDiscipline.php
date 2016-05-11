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
            [['teacher_id', 'ghd_id'], 'required'],
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
            'teacher_id' => 'Преподаватель',
            'ghd_id' => 'Предмет',
            'begin_date' => 'Begin Date',
            'end_date' => 'End Date',
            'disciplineName' => 'Дисциплина',
            'groupName' => 'Группа',
            'semester' => 'Семестр',
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
    
    public function getDisciplineName()
    {
        return $this->groupHasDiscipline->discipline->name;
    }
    
    public function getGroupName()
    {
        return $this->groupHasDiscipline->group->name;
    }
    
    public function getSemester()
    {
        return $this->groupHasDiscipline->semester_number;
    }    
      
}
