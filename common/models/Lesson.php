<?php

namespace common\models;

use Yii;
use DateTime;
/**
 * This is the model class for table "lesson".
 *
 * @property integer $id
 * @property integer $ghd_id
 * @property integer $lesson_type
 * @property integer $teacher_id
 * @property integer $week
 * @property string $day
 * @property string $time
 * @property string $auditory
 */
class Lesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public static function tableName()
    {
        return 'lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ghd_id', 'lesson_type_id', 'thd_id', 'week', 'day',  'auditory'], 'required'],
            [['time'] , 'safe'], 
            [['day', 'ghd_id', 'lesson_type_id', 'thd_id', 'week'], 'integer'],
            [['auditory'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ghd_id' => 'Группа - семестр - дисциплина',
            'lesson_type_id' => 'Тип занятия',
            'thd_id' => 'Преподаватель',
            'week' => 'Неделя',
            'day' => 'День',
            'time' => 'Время',
            'auditory' => 'Аудитория',
            'groupName' => 'Группа',
            'disciplineName' => 'Дисциплина',
            'teacherFullname' => 'Преподаватель',
            'lessonTypeName' => 'Тип занятия'
        ];
    }
    
     /**
     * @get ghd
     */
    public function getGroupHasDiscipline()
    {
        return $this->hasOne(GroupHasDiscipline::className(),['id' => 'ghd_id']);
    }
    
    /**
     * @get teacher
     */
    public function getTeacherHasDiscipline()
    {
        return $this->hasOne(TeacherHasDiscipline::className(),['id' => 'thd_id']);
    }
    
    public function getTeacher()
    {
        return $this->teacherHasDiscipline->teacher->id;
    }

        /**
     * @get teacher
     */
    public function getLessonType()
    {
        return $this->hasOne(LessonType::className(),['id' => 'lesson_type_id']);
    }  

    public function getGroupName()
    {
        return $this->groupHasDiscipline->group->name;
    }

    public function getDisciplineName()
    {
        return $this->groupHasDiscipline->discipline->name;
    }
    
    public function getTeacherFullname()
    {
        return $this->teacherHasDiscipline->teacher->user->fullname;
    }
    
    public function getLessonTypeName()
    {
        return $this->lessonType->name;
    }
    
    /**
     * @get day name
     */
     public static function getDayName($day_num)
     {
         $result;        
         switch($day_num){
             case 1:
                 $result = "Понедельник";
                 break;
             case 2:
                 $result = "Вторник";
                 break;
             case 3:
                 $result = "Среда";
                 break;
             case 4:
                 $result = "Четверг";
                 break;
             case 5:
                 $result = "Пятница";
                 break;
             case 6:
                 $result = "Суббота";
                 break;
             case 7:
                 $result = "Воскресенье";
                 break;
             default : $result = "Ошибка!";
                 break;
         }
         return $result;
     }
     
     public function getDayRealName()
     {
         return $this->getDayName($this->day);
     }
     
     public static function getDaysList()
     {
         $days = array();
         for($i=1; $i < 7; $i++)
         {
            $days[$i]['id'] = $i;
            $days[$i]['name'] = Lesson::getDayName($i);            
         }
         return \yii\helpers\ArrayHelper::map($days,'id','name');
     }

     
     public static function getLessonsList($arr)
     {
        $group = isset($arr['group']) ? $arr['group'] : null;
        $teacher = isset($arr['teacher']) ? $arr['teacher'] : null;
        if($group !== null){
            if(!isset($arr['semester']))
            $semester = Group::findOne($group)
                            ->currentSemester;
            else
                $semester = GroupSemesters::find()->where(['group_id' => $arr['group'],'semester_number' => $arr['semester']])->one();
            if(!$semester)
                return false; 
            $lessons = Lesson::find()
                    ->joinWith('groupHasDiscipline',true,"INNER JOIN")
                    ->where(['group_has_discipline.group_id' => $group])
                    ->andWhere(['group_has_discipline.semester_number' =>
                        $semester->semester_number
                            ])
                    ->orderBy('week ASC, day ASC, time ASC')->all();
            return $lessons;
        }
        elseif($teacher !== null){

                    $lessons = Lesson::find()
                    ->select('lesson.*')                    
                    ->innerJoin("teacher_has_discipline thd")
                    ->innerJoin("group_has_discipline ghd", '`ghd`.`id` = `lesson`.`ghd_id`')
                    ->innerJoin("group g", '`g`.`id` = `ghd`.`group_id`')
                    ->innerJoin("group_semesters gs", '`gs`.`group_id` = `g`.`id` AND `ghd`.`semester_number`  = `gs`.`semester_number`')
                    ->where(['<=','gs.begin_date',date('U')])
                    ->andWhere(['>=','gs.end_date',date('U')])                    
                    ->andWhere(['thd.teacher_id' => $teacher])    
                    ->orderBy('week ASC, day ASC, time ASC, id ASC')->all();  
            return $lessons;
        }
             
     }
     
    
}
