<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TaskType;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use common\models\Group;
use common\models\ExerciseSubject;
use common\models\Task;
use Netcarver\Textile;
use common\models\Exercise;
use common\models\GivenTask;
$parser = new \Netcarver\Textile\Parser();

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs('
    $("#student_id").change(function(){
        $.pjax.reload({container: "#form-give-task"});
    });
        ');

?>


<div class="task-form">        
    
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'form-give-task']); ?>         
    
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>  

    <?= Html::tag('br')?>
    
    <?= Html::label('Тип задания')?>
    
    <?= Html::dropDownList('task_type',$model->task->taskType->id,ArrayHelper::map(TaskType::find()->all(),'id','name'), 
             ['prompt'=>'-Выберите тип заданий-',
              'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('task/listbytype?id=').'"+$(this).val(), function( data ) {
                  $( "select#task" ).html( data );
                });
            ',
            'class' => 'form-control',
            'id' => 'task_type',     
                 ]); ?>
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Задание')?>
    
    <?= Html::dropDownList('task',$model->task->id,ArrayHelper::map(Task::find()->where(['type_id' => $model->task->taskType->id])->all(),'id','name'), 
             ['prompt'=>'-Выберите задание-',
              'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('task/givepreview?id=').'"+$(this).val(), function( data ) {
                  $( "#givepreview" ).html( data );
                });
            ',
            'class' => 'form-control',
            'id' => 'task',     
                 ]); ?>
    
    <?= Html::tag('br')?>
    
    <div class="panel panel-default">
        <div class='panel-heading'>Текст задания</div>
        <div class='panel-body'  id="givepreview" ><?=$parser->textileThis($model->task->text)?></div>
    </div>
    
    <?= Html::label('Тип упражнений')?>
    
    <?= Html::button('Выделить все',['onclick' => 
        '$("#exersice_type option").prop("selected",true); $("#exersice_type option").trigger("change");',
        'class' => 'btn btn-primary btn-xs'
        ])?>
    
    <?= Html::listBox('exersice_type',ArrayHelper::getColumn(ExerciseSubject::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id')
            ,ArrayHelper::map(ExerciseSubject::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id','name'), 
             [
              'onchange'=>'
                var arr = []; 
                $("#exersice_type :selected").each(function(i, selected){ 
                  arr[i] = $(selected).val(); 
                });
                $.post( "'.Yii::$app->urlManager->createUrl('exercise/exersicelistbytype?id=').'"+arr, function( data ) {
                  $( "#exersices" ).html( data );
                });
            ',
            'class' => 'form-control',
            'id' => 'exersice_type',
                 'multiple' => 'true'
                 ]); ?>
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Упражнения')?>
    
    <?= Html::button('Выделить все',['onclick' => 
        '$("#exersices option").prop("selected",true); $("#exersices option").trigger("change");',
        'class' => 'btn btn-primary btn-xs'
        ])?>
                 
              
     <?= Html::listBox('exersices',ArrayHelper::getColumn($model->exercises,'exercise.id'),ArrayHelper::map(Exercise::find()->where(['subject_id' => 
         ArrayHelper::getColumn(ExerciseSubject::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id')])->all(),
             'id','name'), 
             ['class' => 'form-control',
             'id' => 'exersices',
                 'onchange'=>'
                var arr = []; 
                $("#exersices :selected").each(function(i, selected){ 
                  arr[i] = $(selected).val(); 
                });               
                $.post( "'.Yii::$app->urlManager->createUrl('task/exersicespreview?list=').'"+arr, function( data ) {
                  $( "#exersicespreview" ).html( data );
                });
            ',
             'multiple' => 'true'    
                 ]); ?>
    
    <?= Html::tag('br')?>
    
    <div class="panel panel-default">
        <div class='panel-heading'>Список упражнений</div>
             <div class='panel-body'  id="exersicespreview" ><?php
            
            $list = ArrayHelper::getColumn($model->exercises,'exercise.id');
            $exersices = \common\models\Exercise::findAll($list);
            echo $this->render('/task/_exersicespreview',['exersices' => $exersices]);
             ?></div>
    </div>
    
    <?//= $form->field($model, 'student_id')->listBox(TaskType::typeList(),['onchange' => '$.pjax.reload({container: "#form-give-task"});'])?>
        
    <?//= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    
    <?php $this->registerJs(" $('#task-text').markItUp(myTextileSettings);  ");  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>        
    
     <?php if($result)
            echo Html::tag('div','Обновлено!',['class' => 'alert alert-success']); ?>
    
    <?php ActiveForm::end(); ?>
    
    <?php  Pjax::end(); ?>
</div>