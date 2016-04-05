<?php

namespace common\models;

use Yii;
use DateTime;
/**
 * This is the model class for table "group_semesters".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $semester_number
 * @property integer $begin_date
 * @property integer $end_date
 */
class GroupSemesters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_semesters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'semester_number', 'begin_date', 'end_date'], 'required'],
            [['group_id', 'semester_number', 'begin_date', 'end_date'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'semester_number' => 'Номер семестра',
            'begin_date' => 'Начало',
            'end_date' => 'Конец',
        ];
    }
    
    
    public static function createSemestersForGroup($group,$count,$beginYear)
    {                          
        $year = $beginYear;
        $date = new DateTime();        
        $date->setDate($year, 1, 1);
        for($i = 1; $i <= $count;$i++)
        {
            $GS = new GroupSemesters();            
            if($i%2){                
                $date->setDate($date->format("Y"), 9, 1);
                $beginDate = $date->format('U');
                $date->setDate($date->format("Y")+1,2,1);
                $endDate = $date->format('U');
            }
            else{
                $date->setDate($date->format("Y"), 2, 10);
                $beginDate = $date->format('U');
                $date->setDate($date->format("Y"),7,1);
                $endDate = $date->format('U');
            }
            $GS->begin_date = $beginDate;
            $GS->end_date = $endDate;
            $GS->group_id = $group;
            $GS->semester_number = $i;
            if(!GroupSemesters::find()->where(['group_id' => $group,
                'semester_number' => $i])->count())
            $GS->save();
        }            
    }
}
