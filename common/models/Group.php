<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property string $name
 * @property integer $speciality_id
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'speciality_id'], 'required'],
            [['speciality_id','steward_student_id'], 'integer'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Группа',
            'speciality_id' => 'Специальность',
            'steward_student_id' => 'Староста',
            'specialityName' => 'Специальность'
        ];
    }
    
    /**
     * @get students
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(),['group_id' => 'id']);
    }
    
    public function getStudentsOrderedByLastName()
    {       
            return Student::find()
                    ->joinWith('user')
                    ->select('student.*')                    
                    ->where(['student.group_id' => $this->id])                    
                    ->orderBy('user.last_name')
                    ->all();
        
    }
    
    /**
     * @get disciplines
     */
    public function getDisciplines()
    {
        return $this->hasMany(GroupHasDiscipline::className(), ['group_id' => 'id'])->orderBy('semester_number DESC');
    }
    
    public function getCurrentDisciplines()
    {
        return $this->hasMany(GroupHasDiscipline::className(), ['group_id' => 'id'])->where(['semester_number' => $this->currentSemester->semester_number]);
    }
    
    public function getDisciplineList()
    {
        return Discipline::find()
                ->select('discipline.*')
                ->joinWith('groupHasDisciplines')
                ->where(['group_has_discipline.group_id' => $this->id])
                ->all();
    }
    
    public function getLesson()
    {
         return Lesson::find()->all();
    }
    
    /**
     * @get speciality
     */
    public function getSpeciality()
    {
        return $this->hasOne(Speciality::className(),['id' => 'speciality_id']);
    }
   
    public function getAnounces()
    {
        return $this->hasMany(GroupAnounces::className(), ['group_id' => 'id'])->orderBy('id DESC');
    }
    
    public function getSteward()
    {
        return $this->hasOne(Student::className(), ['id' => 'steward_student_id']);
    }
    
    public function getCurrentSemester()
    {
        //return $this->hasOne(GroupSemesters::className(), ['group_id' => 'id']);       
        
            return GroupSemesters::find()
                ->where(['group_id' => $this->id])
                ->andWhere(['<=','begin_date',date('U')])
                ->andWhere(['>=','end_date',date('U')])
                ->one(); 
    }
    
    public function getCurrentSemesterNumber(){
        if(isset($this->currentSemester))
            return $this->currentSemester->semester_number;
        else return "-";
    }

        public function getSpecialityName()
    {
        return $this->speciality->name;
    }
    
    public function getSemesters()
    {
        return $this->hasMany(GroupSemesters::className(), ['group_id' => 'id']);
    }
       
}
