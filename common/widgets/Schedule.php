<?php

namespace common\widgets;
use Yii;
use common\models\Lesson;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
class Schedule extends \yii\bootstrap\Widget
{
    const SCENARIO_GROUP = 'group';
    const SCENARIO_TEACHER = 'teacher';

    public $lessons;
    public $week;    
    public $days;
    public $scenario;
    
    public $attributes = [
        'disciplineName',
        'time',
        'auditory',
        'lessonTypeName',
    ];
    
    
    public $teacher = 'teacherFullname';
    public $group = 'groupName';
    public $discipline = 'disciplineName';

    public function init()
    {
        
        parent::init();
        if($this->week === null){
            $this->week = 1;
        }
        if($this->days === null){
            $this->days = 6;
        }        
        if($this->lessons == false){
            $this->scenario = null;
        }            
        if($this->scenario === Schedule::SCENARIO_GROUP){
            array_push($this->attributes, $this->teacher);
        }
        elseif($this->scenario === Schedule::SCENARIO_TEACHER){
            array_push($this->attributes, $this->group);
        }
    }        
   
    private function getLessonsList($lessons_array,$week, $day)
    {
        foreach ($lessons_array as $key => $element){
            if(($element->week != $week)||($element->day != $day))
                unset($lessons_array[$key]);
        }
        $lessons = $lessons_array;        
        $items = array();
        $result = array();
        foreach ($lessons as $lesson){ 
            foreach($this->attributes as $attr){                 
                if($attr == $this->group){
                    $items[] = Html::tag('td',Html::a($lesson->$attr,  Url::to(['//group/view','id' => $lesson->groupHasDiscipline->group->id])));    
                }
                elseif($attr == $this->teacher){
                    $items[] = Html::tag('td',Html::button($lesson->$attr,
                        ['value' => Url::to(['//teacher/view','id' => $lesson->teacherHasDiscipline->teacher->id]),
                            'class' => 'btn-link modalButton']));    
                }
                elseif(($attr == $this->discipline)&&(Yii::$app->user->can('chief')||(isset(Yii::$app->user->identity->student))&&(($lesson->groupHasDiscipline->checkStudent(Yii::$app->user->identity->student->id))
                        )||($lesson->groupHasDiscipline->checkTeacher(Yii::$app->user->identity->teacher->id)))){                          
                       $items[] = Html::tag('td',Html::a($lesson->groupHasDiscipline->discipline->name,Url::to(['//group-has-discipline','id' => $lesson->groupHasDiscipline->id]),
                        ['class' => 'btn-link']));
                }
                else{
                    $items[] = Html::tag('td',$lesson->$attr);
                }
            }          
            $result[] = Html::tag('tr', implode("\n", $items));
            $items = null;
        }
        return Html::tag('tr', implode("\n", $result));
    }
    
    private function getDaysList($lessons_array,$week)
    {        
        $items = array();
        for($day = 1; $day <= $this->days; $day++){
            $dayTitle = Html::tag('th', Lesson::getDayName($day), ['class' => 'center-align grey-color', 'colspan'=> '5']);            
            $items[] = Html::tag('tr',$dayTitle);
            $lesson = new Lesson();
            foreach($this->attributes as $attr){
                $label = $lesson->getAttributeLabel($attr);
                $items[] = Html::tag('th',$label, ['class' => 'center-align']);
            }
            $items[] = $this->getLessonsList($lessons_array,$this->week, $day);
        }
        return Html::tag('tr', implode("\n", $items));
    }
    
    private function renderWeek($lessons,$week)
    {
        $tableTable = Html::tag('table',$this->getDaysList($lessons,$week),['class' => 'table-condensed table table-striped center-align']);
        $tableDiv = Html::tag('div',$tableTable,['class' => 'table table-responsive']);
        return $tableDiv;
    }

    public function run()
    {      
        if($this->scenario === null)
            return '<h2>Ничего не найдено</h2>';
        else
            return $this->renderWeek($this->lessons, $this->week);
                  
    }
}
