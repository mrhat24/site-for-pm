<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $name
 * @property integer $student
 * @property integer $teacher
 * @property integer $date
 * @property integer $approve_status
 */
class Work extends \yii\db\ActiveRecord
{
    const SCENARIO_GRADUATE = 'graduate';
     const SCENARIO_TERM = 'term';
    const TYPE_GRADUATE = 1;
    const TYPE_TERM = 2;
    
    const STATUS_NOT_SENDED = null;
    const STATUS_SENDED = 1;
    const STATUS_NOT_APPROVED = 2;
    const STATUS_APPROVED = 3;
    

    public $group;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work';
    }

    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_GRADUATE] = ['student_id', 'unique'];
        //$scenarios[self::SCENARIO_TERM] = ['discipline_id', 'required'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
            ['student_id', 'unique', 'on' => self::SCENARIO_GRADUATE],            
            [['work_type_id', 'student_id', 'teacher_id', 'date'], 'required'],
            [['work_type_id', 'name', 'student_id', 'teacher_id', 'date', 'approve_status','reserved_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_type_id' => 'Тип',
            'name' => 'Название',
            'student_id' => 'Студент',
            'teacher_id' => 'Преподаватель',
            'date' => 'Дата',
            'approve_status' => 'ID Статуса',
            'studentFullname' => 'Ф.И.О. студента',
            'groupName' => 'Группа',
            'status' => 'Статус',
            'discipline_id' => 'Дисциплина'
        ];
    }
    
    public function afterDelete() {
        parent::afterDelete();
        WorkHistory::deleteAll(['work_id' => $this->id]);
    }

        /**
     * @get work type
     */
    public function getWorkType()
    {
        return $this->hasOne(WorkType::className(),['id' => 'work_type_id']);
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
    
    public function getWorkReserved()
    {
        return $this->hasOne(WorkList::className(),['id' => 'reserved_id']);
    }
    
     /**
     * @get work history
     */
    public function getWorkHistory()
    {
        return $this->hasMany(WorkHistory::className(),['work_id' => 'id']);
    }
    
    /**
     * @get work from work list
     */    
    public function getWorkTitle()
    {
        return $this->hasOne(WorkHistory::className(),['id' => 'name']);
    }
    
    public function getStatus()
    {
        switch($this->approve_status){
            case(1):
                $result = 'Отправлено на утверждение';
            break;
            case(2):
                $result = 'Не принято';
            break;
            case(3):
                $result = 'Утверждено';
            break;
            default:
                $result = 'Не утверждено';
            break;
        }
        return $result;
    }
    
    public function beginGraduate($request)
    {
        $this->scenario = 'graduate';
        $nowDate = date("U");
            $workHistory = new \common\models\WorkHistory();      
            if(isset(Yii::$app->request->post()['newWorkCheckbox'])&&
                    (Yii::$app->request->post()['newWorkCheckbox']==true)){
               $teacher = Yii::$app->request->post()['newWorkTeacher'];
               $stringName = Yii::$app->request->post()['newWorkName'];
               $work_list_id = null;
            }
            else{
                $workFromList = \common\models\WorkList::findOne(Yii::$app->request->post()['workList']);
                $teacher = $workFromList->teacher_id;
                $stringName = $workFromList->name;
                $work_list_id = $workFromList->id;
            }
                $workModel->work_type_id = 1;
                $workModel->teacher_id = $teacher;
                $workModel->student_id = Yii::$app->user->identity->student->id;
                $workModel->date = $nowDate;
                $workModel->reserved_id = $workFromList->id;
                if($workModel->save()){
                    $workHistory->work_id = $workModel->getPrimaryKey();
                    $workHistory->name = $stringName;
                    $workHistory->creation_date = $nowDate;
                    if($workHistory->save()){   
                        $workModel->name = $workHistory->getPrimaryKey();
                        $iterator = $workModel->name;
                        $workModel->save();
                        if(isset($workFromList)){
                        $workFromList->save();
                        }
                        return $this->renderAjax('complete_begin_graduate',
                                    ['iterator' => $iterator]);   
                    }
                }
    }

    public function editGraduate($request)
    {        
        $date = date('U');
        switch($request['source']){
                case "edit":{
                    if(trim($request['work_name']) != $this->workTitle->name){
                        $newWorkName = new WorkHistory();
                        $newWorkName->creation_date = $date;
                        $newWorkName->name = $request['work_name'];
                        $newWorkName->work_id = $this->id;
                        if($newWorkName->save()){
                            $this->name = $newWorkName->getPrimaryKey();
                            $this->save();
                        }
                    }                    
                }
                break;
                case "history":{
                    $this->name = $request['oldWorkList'];
                    $this->save();
                }
                break;
                case "list":{                    
                    $newWorkName = new WorkHistory();
                    $wfl = WorkList::findOne($request['workList']);                    
                    $newWorkName->creation_date = $date;
                    $newWorkName->work_id = $this->id;
                    $newWorkName->name = $wfl->name;
                    if($newWorkName->save()){
                            $this->name = $newWorkName->getPrimaryKey();                            
                            $this->save();
                    }
                }
                break;
                default:
                break;
            }
    }
    
    public function editTerm($request)
    {
        $date = date('U');
        switch($request['source']){
                case "edit":{
                        $newWorkName = new WorkHistory();
                        $newWorkName->creation_date = $date;
                        $newWorkName->name = $request['editName'];
                        $newWorkName->work_id = $this->id;
                        if($newWorkName->save()){                            
                            $this->name = $newWorkName->getPrimaryKey();
                            $this->save();
                        }                   
                }
                case "new":{
                    
                        $newWorkName = new WorkHistory();
                        $newWorkName->creation_date = $date;
                        $newWorkName->name = $request['newName'];
                        $newWorkName->work_id = $this->id;
                        if($newWorkName->save()){
                            $this->reserved_id = null;
                            $this->name = $newWorkName->getPrimaryKey();
                            $this->save();
                        }                   
                }
                break;
                case "history":{
                    $this->name = $request['oldWorkName'];
                    $this->save();
                }
                break;
                case "list":{                    
                    $newWorkName = new WorkHistory();
                    $wfl = WorkList::findOne($request['listWorkName']);
                    $newWorkName->creation_date = $date;
                    $newWorkName->work_id = $this->id;
                    $newWorkName->name = $wfl->name;
                    if($newWorkName->save()){
                            $this->reserved_id = $wfl->id;
                            $this->name = $newWorkName->getPrimaryKey();                            
                            $this->save();
                    }
                }
                break;
                default:
                break;
            }     
    }


    public static function changeStatus($student,$status,$type)
    {
        $work = Work::find()
                ->where(['student_id' => $student,
                    'work_type_id' => $type])->one();
        $work->approve_status = $status;
        if($work->save())
            return true;
        else
            return false;
    }
    
    public function getStudentFullname()
    {
        return $this->teacher->user->fullname;
    }
    
    public function getGroupName()
    {
        return $this->student->group->name;
    }
    
}
