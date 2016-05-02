<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "given_task".
 *
 * @property integer $id
 * @property string $date
 * @property integer $student
 * @property integer $group
 * @property integer $teacher
 * @property integer $task
 * @property string $exercises
 * @property integer $discipline
 */
class GivenTask extends \yii\db\ActiveRecord
{
    public static $statusArray = [0 => 'Не решено',
        1 => 'Отправлено на проверку',
        2 => 'Есть нарекания',
        3 => 'Завершено'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'given_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'teacher_id', 'task_id','discipline_id','result','given_date','deadline_date'], 'required'],            
            [['student_id', 'teacher_id', 'task_id', 'discipline_id','status','complete_date','result'], 'integer'],
            [['comment','group_key'], 'string'],
            [['status','result'], 'default', 'value' => 0],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'given_date' => 'Дата выдачи',
            'complete_date' => 'Дата завершения',
            'deadline_date' => 'Дата окончания срока',
            'student_id' => 'id студента',      
            'teacher_id' => 'id преподавателя',
            'task_id' => 'id задания',
            'comment' => 'Комментарий',
            'discipline_id' => 'id дисциплины',
            'status' => 'Статус',
            'result' => 'Результат',   
            'teacherFullname' => 'Преподаватель',
            'studentFullname' => 'Студент',
            'taskName' => 'Название задания',
            'group' => 'Группа'
        ];
    }
        
     /*
     * @ get status identity
     */
    public function getStatusIdentity()
    {
        switch ($this->status)
        {
            case 0:
                return ['ident' => 'warning','rus' => 'Не решено'];
            case 1:
                return ['ident' => 'info','rus' => 'Отправлено на проверку'];
            case 2:
                return ['ident' => 'danger','rus' => 'Есть нарекания'];
            case 3:
                return ['ident' => 'success','rus' => 'Завершено'];
        }
    }
    
    /**
     * @get student
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(),['id' => 'student_id']);
    }
    /**
     * @get teacher
     */
    public function getTeacher()
    {
        return $this->hasOne(Teacher::className(),['id' => 'teacher_id']);
    }
    
    /*
     * @get teacher fullname
     */
    public function getTeacherFullname()
    {
        return $this->teacher->user->fullname;
    }
    
    /*
     * @get student fullname
     */
    public function getStudentFullname()
    {
        return $this->student->user->fullname;
    }

    /**
     * @get discipline
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(),['id' => 'discipline_id']);
    }
    
    /**
     * @get exercises
     */
    public function getExercises()
    {
        //$exers = json_decode($this->exercises_list);
        //return Exercise::find()->where(['id' => $exers])->all();
        return $this->hasMany(GivenExercise::className(), ['given_task_id' => 'id']);
    }
    /**
     * @get task
     */
    public function getTask()
    {
        
        return $this->hasOne(Task::className(),['id' => 'task_id']);
    } 
    
    public function getTaskName()
    {
        return $this->task->name;
    }

        public function getUser()
    {
        return $this->hasOne(User::className(),['id' => 'user_id'])
                ->via('student');
    }

    
    public static function createGivenTask($post)
    {
        $exersices = $post['exersices'];
        $students = $post['students'];
        $discipline = $post['discipline'];
        $teacher = Yii::$app->user->identity->teacher->id;
        $task = $post['task'];
        $deadline = 0;
        if($post['deadline_date'])
            $deadline = Yii::$app->formatter->asTimestamp($post['deadline_date']);
        $given_date = date('U');
        if($post['given_date'])
            $given_date = Yii::$app->formatter->asTimestamp($post['given_date']);
        $group_key = md5($given_date);
        $noerror = true;
        foreach($students as $student)
        {            
            $model = new GivenTask();
            $model->given_date = $given_date;
            $model->student_id = $student;
            $model->teacher_id = $teacher;
            $model->discipline_id = $discipline;
            $model->task_id = $task;
            $model->deadline_date = $deadline;
            $model->group_key = $group_key;
            if($model->save()){ 
            foreach($exersices as $exersice)
            {
                $eModel = new GivenExercise();
                $eModel->exercise_id = $exersice;
                $eModel->given_task_id = $model->getPrimaryKey();
                $eModel->save();  
            }
            } else $noerror = false;
        }        
        return $noerror;
    }
    
    public static function updateGivenTask($post,$model)
    {
        $newExersices = $post['exersices'];
        foreach($newExersices as $key => $ex)
        {
            $newExersices[$key] = (int) $ex;
        }
        $task = $post['task'];
        $given_date = date('U');
        $noerror = true;
            $model->given_date = $given_date;
            $model->task_id = $task;
            if($model->save()){
                $lastEx = ArrayHelper::getColumn($model->exercises,'exercise.id');
                $generalEx = array_intersect($newExersices, $lastEx);
                $newLast = array_diff($lastEx,$generalEx);
                $newEx = array_diff($newExersices,$generalEx);
                sort($newLast);
                sort($newEx);
                foreach($newEx as $newExerc)
                {
                    $eModel = new GivenExercise();
                    $eModel->exercise_id = $newExerc;
                    $eModel->given_task_id = $model->getPrimaryKey();
                    $eModel->save();
                }
                foreach($newLast as $delLast)
                {
                    $eModel = GivenExercise::find()->where(['given_task_id' => $model->getPrimaryKey()])->andWhere(['exercise_id' => $delLast])->one();
                    $eModel->delete();
                }
            } else $noerror = false;
        return $noerror;
    }
    
    public static function listToArray($list)
    {
        return explode(',', $list);
    }
    
    public static function newTakenTasksCount()
    {
        return GivenTask::find()->where(['student_id' => Yii::$app->user->identity->student->id])->andWhere(['!=','status','3'])->count();    
    }
        
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            GivenExercise::deleteAll(['given_task_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }
    
    public function getGroup()
    {
        return $this->student->group->name;
    }

}
