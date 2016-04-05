<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "work_list".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $author
 */
class WorkList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'work_type_id', 'teacher_id'], 'required'],
            [['work_type_id', 'teacher_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'work_type_id' => 'Work Type',
            'teacher_id' => 'Teacher',
            
        ];
    }
    
    /**
     * @get work type
     */
     public function getWorkType(){
         return $this->hasOne(WorkType::className(),['id' => 'work_type_id']);
     }
     
     /**
     * @get author
     */
     public function getTeacher(){
         return $this->hasOne(Teacher::className(),['id' => 'teacher_id']);
     }
     
     /**
     * @get reserved work id
     */
     public function getisChosen(){
         if(Work::find()->where(['reserved_id' => $this->id])->count())
             return true;
         else return false;
     }
     
     public function getisReserved(){
         if(Work::find()->where(['reserved_id' => $this->id, 'approve_status' => 3])->count())
             return true;
         else return false;
     }
     
     public function getReserved(){
         return $this->hasOne(Work::className(),['reserved_id' => 'id']);
     }
}
