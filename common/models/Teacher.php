<?php

namespace common\models;

use Yii;
use common\models\TeacherHasDiscipline;
/**
 * This is the model class for table "teacher".
 *
 * @property integer $id
 * @property integer $user_id
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['post','academic_degree'],'safe'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'post' => 'Должность',
            'academic_degree' => 'Ученая степень',
            'fullname' => 'Ф.И.О.'
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @get exercises
     */
    public function getExercises()
    {
        return $this->hasMany(Exercise::className(),['teacher_id' => 'id']);
    }
    
    /**
     * @get given tasks
     */
    public function getGivenTasks()
    {
        return $this->hasMany(GivenTask::className(),['teacher_id' => 'id']);
    }
    
    /**
     * @get tasks
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(),['teacher_id' => 'id']);
    }
    
    /**
     * @get given lessons
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::className(),['teacher_id' => 'id']);
    }
    
    /**
     * @get works
     */
    public function getWorks()
    {
        return $this->hasMany(Work::className(),['teacher_id' => 'id']);
    }
    
    /**
     * @get graduate
     */
    public function getGraduates()
    {
        return $this->hasMany(Work::className(),['teacher_id' => 'id'])->where(['work_type_id' => Work::TYPE_GRADUATE]);
    }
    
    /**
     * @get works
     */
    public function getTerms()
    {
        return $this->hasMany(Work::className(),['teacher_id' => 'id'])->where(['work_type_id' => Work::TYPE_TERM]);
    }
    
    /**
     * @get work list
     */
    public function getWorkList()
    {
        return $this->hasMany(WorkList::className(),['teacher_id' => 'id']);        
    }
    
    public function getDisciplineList()
    {
        $discipline = Discipline::find()->select('discipline.*')
                ->leftJoin('group_has_discipline','group_has_discipline.discipline_id = discipline.id')
                ->leftJoin('teacher_has_discipline','`teacher_has_discipline`.`ghd_id` = `group_has_discipline`.`id`')
                ->where(['teacher_has_discipline.teacher_id' => Yii::$app->user->identity->teacher->id])
                ->all();
        return $discipline;
    }        
    
    public function getTeacherHasDiscipline()
    {
        return $this->hasMany(TeacherHasDiscipline::className(),['teacher_id' => 'id']);
    }
    
    
    public function getNewTasksCheckCount()
    {
        return GivenTask::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->andWhere(['status' => '1'])->count();    
    }
    
    public function getFullname()
    {
        return $this->user->fullname;
    }
    
    public function getGroups()
    {
        return Group::find()
                ->innerJoin("group_has_discipline ghd", '`ghd`.`group_id` = `group`.`id`')
                ->innerJoin("lesson", '`lesson`.`ghd_id` = `ghd`.`id`')->all();
    }
    
    public function getAnounces()
    {
        return GroupAnounces::find()->where(['user_id' => $this->user->id])->orderBy('id DESC')->all();
    }
    
    public function isTeacherHasDiscipline($id)
    {
        $isTeacherHasDiscipline = GroupHasDiscipline::find()->joinWith('teacherHasDiscipline')
                    ->where(['group_has_discipline.id' => $id])
                    ->andWhere(['teacher_has_discipline.teacher_id' => $this->id])
                    ->count();
        return $isTeacherHasDiscipline;
    }
}
