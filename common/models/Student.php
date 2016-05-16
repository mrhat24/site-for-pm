<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property string $education_start_date
 * @property string $education_end_date
 *
 * @property User $user
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id'], 'required'],
            [['user_id', 'group_id'], 'integer'],
            [['education_start_date', 'education_end_date'], 'safe'],
            [['user_id','srb'], 'unique']
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
            'group_id' => 'Группа',
            'education_start_date' => 'Дата поступления',
            'education_end_date' => 'Дата окончания',
            'fullname' => 'Ф.И.О.',
            'groupName' => 'Группа',
            'srb' => 'Номер зачетной книжки'
        ];
    }

    /**
     * @get user
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @get works
     */
    public function getWorks()
    {
        return $this->hasMany(Work::className(),['student_id' => 'id']);
    }  
    
    /**
     * @get given tasks
     */
    public function getGivenTasks()
    {
        return $this->hasMany(GivenTask::className(),['student_id' => 'id']);
    }
    
    /**
     * @get is steward
     */
    public function getIsSteward()
    {
        return ($this->group->steward_student_id == $this->id);
    }
    
    /**
     * @get group
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(),['id' => 'group_id']);
    }  
    
    public function getNewTasksCount()
    {
        return GivenTask::find()->where(['student_id' => Yii::$app->user->identity->student->id])
                ->andWhere(['!=','status','3'])->andWhere(['!=','status','1'])->count();    
    }
    
    public function getFullname()
    {
        return $this->user->fullname;
    }
    
    public function getGroupName()
    {
        return $this->group->name;
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);                
        $this->education_start_date = Yii::$app->formatter->asTimestamp($this->education_start_date);
        $this->education_end_date = Yii::$app->formatter->asTimestamp($this->education_end_date);
        return true;
    }
    
    public function getRate()
    {
       return 0;
    }
    
    public function getTaskStat()
    {
        $deadline = 0;
        $date = date('U');        
        $array = array();        
        foreach(GivenTask::$statusArray as $key => $value){ 
            $count = GivenTask::find()->where(['status' => $key, 'student_id' => $this->id])->count();
            $array[] = ['status' => $value, 'value' => $count];
        }
        return $array;
    }
    
    public function getGpa()
    {
        if($this->givenTasks){
            $gpa = 0;
            $i = 0;
            foreach($this->givenTasks as $gt){
                $gpa = $gpa + $gt->result;
                $i++;
            }
            return round($gpa/$i,1);
        }
        return 0;
    }


    public function getTasksCount()
    {
        return GivenTask::find()->where(['student_id' => $this->id])->count();
    }
}
