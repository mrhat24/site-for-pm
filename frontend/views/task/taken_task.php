<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use common\components\DateHelper;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use Netcarver\Textile;
$parser = new \Netcarver\Textile\Parser();

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $takenTask->task->name;
$this->params['breadcrumbs'][] = ['label' => 'Студенту', 'url' => Url::to(['site/student'])];
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => Url::to(['task/taken'])];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-index"> 

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <?php
   echo $parser->textileThis($takenTask->task->text);
   echo Html::tag("span",'Дата выдачи задания: '.DateHelper::getDateByUserTimezone($takenTask->given_date),['class' => 'date']);
         
    ?>
     <hr/>
    
    <?php
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
    echo Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Скачать в pdf',
            Url::to(['task/pdf-task', 'id' => $takenTask->id]),
            ['class' => 'btn btn-success', 'target'=>'_blank','data-pjax'=>0]); 
    echo '</div>';
    Pjax::end();
    
    ?> </div>
    <hr/>
    <?php
    
    foreach ($takenTask->exercises as $key => $exercise){
      //  if((($completeExersice = common\models\CompleteExercise::find()->where(['exercise_id' => $exercise->id])->andWhere(['given_task_id' => $takenTask->id])->one()) !== null)){
      //      $complete = true;
        //}
        $index = $key+1;        
        $remake = 'panel-primary';
        //if($complete&&($exercise->remake != 0)) $remake = 'panel-danger';
        echo Html::beginTag('div',['class' => 'panel '.$remake]);                
        echo Html::tag('div','Задание#'.$index,['class' => 'panel-heading']);
        echo Html::beginTag('div',['class' => 'panel panel-info']);
        echo Html::tag('div','Описание',['class' => 'panel-heading']);
        echo Html::tag('div',$parser->textileThis($exercise->exercise->text),['class' => 'panel-body']);
        echo Html::endTag('div');        
    
       // if($complete){        
       // Pjax::begin(['enablePushState' => false, 'id' => 'form-exersice']);
        //echo Html::beginTag('blockquote');
        echo Html::beginTag('div',['class' => 'panel panel-info']);
        echo Html::tag('div','Ваше решение',['class' => 'panel-heading']);
        echo Html::tag('div',$parser->textileThis($exercise->solution),['class' => 'panel-body']);
        echo Html::endTag('div');      
        //echo Html::endTag('blockquote');
        if($exercise->comment != null){
            echo Html::beginTag('div',['class' => 'panel panel-info']);
            echo Html::tag('div','Коментарий преподавателя',['class' => 'panel-heading']);
            echo Html::tag('div',$exercise->comment,['class' => 'panel-body']);
            echo Html::endTag('div');
        }       
        //echo Html::tag('div','Дата последнего редактирования: '.DateHelper::getDateByUserTimezone($exercise->date),['class' => 'panel-footer']);
        
        
       // Pjax::end();       
        //}    
        if((($takenTask->status == 2)&&($exercise->remake == 1))||($takenTask->status == 0))
        echo Html::button('Решать',['value'=> Url::to(['given-exercise/edit', 
            'id' => $exercise->id, 'gid' => $takenTask->id]),'class' => 'btn btn-block btn-primary modalButton']);
        
        echo Html::endTag('div');
        echo "<hr/>";
    }     
    ?>
    <?php
    Modal::begin([
            'header' => '<h2>Решение задачи</h2>',
            //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
    
    ?>

</div>
