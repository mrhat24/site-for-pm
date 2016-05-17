<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "group_has_discipline".
 *
 * @property integer $id
 * @property integer $discipline_id
 * @property integer $group_id
 * @property integer $semester_num
 * @property string $start_date
 * @property string $end_date
 */
class GroupHasDiscipline extends \yii\db\ActiveRecord
{    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_has_discipline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discipline_id', 'group_id', 'semester_number'], 'required'],
            [['discipline_id', 'group_id', 'semester_number'], 'integer'],
            [['information'],'string'],
            [['discipline_id', 'group_id', 'semester_number'], 'unique', 
                'targetAttribute' => ['discipline_id', 'group_id', 'semester_number']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'discipline_id' => 'Дисциплина',
            'group_id' => 'Группа',
            'semester_number' => 'Семестр',
            'semesterNumber' => 'Номер семестра',
            'groupName' => 'Группа',
            'disciplineName' => 'Дисциплина',
            'teacherHasDiscipline' => 'Преподаватели',
            'information' => 'Информация'
        ];
    }
    
    /**
     * @get discipline
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(),['id' => 'discipline_id']);
    }
    
     /**
     * @get discipline
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(),['id' => 'group_id']);
    }
    
     /**
     * @get lessons
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::className(),['ghd_id' => 'id']);
    }
    
    public function getSemester()
    {
        return $this->hasOne(GroupSemesters::className(), ['semester_number' => 'semester_number']);
    }
    
    public function getSemesterNumber()
    {
        return $this->semester_number;
    }
    
    public function getGroupName()
    {
        return $this->group->name;
    }
    
    public function getDisciplineName()
    {
        return $this->discipline->name;
    }
    
    public function getTeacherHasDiscipline()
    {
        return $this->hasMany(TeacherHasDiscipline::className(), ['ghd_id' => 'id']);
    }
    
    public function getGroupSemDisc()
    {
        return $this->group->name.". Семестр - ".$this->semesterNumber.":".$this->discipline->name;
    }    
    
    public function getDiscGroupSem()
    {
        return "Дисциплина: ".$this->discipline->name.". Группа: ".$this->group->name.". Семестр: ".$this->semester_number.".";
    }
    
    public function getDiscSem()
    {
        return "Дисциплина: ".$this->discipline->name.". Семестр: ".$this->semester_number.".";
    }
    
    public function checkTeacher($id)
    {
        return GroupHasDiscipline::find()->joinWith('teacherHasDiscipline')
                ->joinWith('teacherHasDiscipline.teacher')->where(['teacher.id' => $id])
                ->andWhere(['group_has_discipline.id' => $this->id])->count();
    }
    
    public function checkStudent($id)
    {
        return GroupHasDiscipline::find()
                ->joinWith('group')
                ->joinWith('group.students')                
                ->andWhere(['student.id' => $id])
                ->andWhere(['group_has_discipline.id' => $this->id])
                ->count();
    }
}
