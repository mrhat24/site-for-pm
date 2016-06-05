<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use common\components\DateHelper;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Markdown;

$formatter = Yii::$app->formatter;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $takenTask->task->name;
$this->params['breadcrumbs'][] = ['label' => 'Кабинет студента', 'url' => Url::to(['//student/cabinet'])];
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => Url::to(['given-task/taken'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index"> 

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <?php          
    echo Html::tag("h6",'Дата выдачи задания: '.$formatter->asDateTime($takenTask->given_date));
    echo Html::tag("h6",'Дисциплина: '.$takenTask->groupHasDiscipline->discipline->name);
    $teacher = Html::button($takenTask->teacher->user->fullname,['value' => Url::to(['//teacher/view','id' => $takenTask->teacher->id]), 'class' => 'btn btn-xs btn-link modalButton']);
    echo Html::tag("h6",'Преподаватель: '.$teacher);    
    echo "<hr/>"; 
    echo Markdown::process($takenTask->task->text);
    echo "<hr/>"; 
    Pjax::begin(['enablePushState' => false, 'id' => 'send']);
    echo "<div class='btn-group'>";
    switch ($takenTask->status)
    {
        case 2:
        case 0:{
            echo Html::a('Отправить преподавателю',['task/complete-task', 'id' => $takenTask->id], ['class' => 'btn btn-primary']);
        }
        break;
        case 1:{
            echo Html::tag('p','Отправлено на проверку',['class' => 'btn bg-info']);
        }
        break;
        case 3:{
            echo Html::tag('span','Оценка: '.$takenTask->result,['class' => 'btn bg-success']);
        }
        break;
    }   
    echo Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Подготовить к печати',
            Url::to(['task/pdf-task', 'id' => $takenTask->id]),
            ['class' => 'btn btn-success', 'target'=>'_blank','data-pjax'=>0]); 
    echo '</div>';
    Pjax::end();
    
    ?> </div>
    <hr/>
    <?php
    
    foreach ($takenTask->exercises as $key => $exercise){      
        $index = $key+1;        
        $remake = 'panel-primary';
        if($exercise->remake != 0) { $remake = 'panel-danger'; }
        echo Html::beginTag('div',['class' => 'panel '.$remake]);                
        echo Html::tag('div','Задание#'.$index." ".$exercise->exercise->name,['class' => 'panel-heading']);
        echo Html::beginTag('div',['class' => 'panel panel-info']);
        echo Html::tag('div','Описание',['class' => 'panel-heading']);
        echo Html::tag('div',Markdown::process($exercise->exercise->text),['class' => 'panel-body']);
        echo Html::endTag('div');        
        echo Html::beginTag('div',['class' => 'panel panel-info']);
        echo Html::tag('div','Ваше решение',['class' => 'panel-heading']);
        if($exercise->exercise->exerciseTests){
            $checkboxes = Html::checkboxList('answers',$exercise->answers,\yii\helpers\ArrayHelper::map($exercise->exercise->exerciseTests, 'id','value'),['separator' => '<br>','itemOptions' => ['disabled' => true]]);           
            echo Html::tag('div',$checkboxes,['class' => 'well well-sm']);
        }
        else
        echo Html::tag('div',Markdown::process($exercise->solution),['class' => 'panel-body']);
        echo Html::endTag('div');      
        if($exercise->comment != null){
            echo Html::beginTag('div',['class' => 'panel panel-info']);
            echo Html::tag('div','Коментарий преподавателя',['class' => 'panel-heading']);
            echo Html::tag('div',Markdown::process($exercise->comment),['class' => 'panel-body']);
            echo Html::endTag('div');
        }       

        if((($takenTask->status == 2)&&($exercise->remake == 1))||($takenTask->status == 0))
        echo Html::button('Решать',['value'=> Url::to(['given-exercise/edit', 
            'id' => $exercise->id, 'gid' => $takenTask->id]),'class' => 'btn btn-block btn-primary modalButton']);
        
        echo Html::endTag('div');
        echo "<hr/>";
    }     
    ?>
</div>
    <?php
    Modal::begin([            
            //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
    
    ?>
