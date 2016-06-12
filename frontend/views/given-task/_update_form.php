<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TaskType;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use yii\helpers\Markdown;
use yii\helpers\ArrayHelper;
use common\models\ExerciseSubject;
use common\models\Task;
use common\models\Exercise;
use kartik\select2\Select2;
use yii\helpers\Url;
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
    
    <?php 
        echo Select2::widget([
        'name' => 'task_type',
        'id' => 'task_type',   
        'value' => $model->task->taskType->id,
        'data' => ArrayHelper::map(TaskType::find()->all(),'id','name'),
        'options' => ['placeholder' => 'Выберите тип заданий ...',
              'onchange'=>'                  
                $.post( "'.Url::to(['//task/listbytype','id' => '']).'"+$(this).val(), function( data ) {
                  $( "select#task" ).html( data );
                }); ',],
        'pluginOptions' => [
            'tags' => true,            
        ],
    ]);
    ?>
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Задание')?>
    
    <?php 
        echo Select2::widget([
        'name' => 'task',
        'id' => 'task',     
        'value' => $model->task->id,
        'data' => ArrayHelper::map(Task::find()->where(['type_id' => $model->task->taskType->id])->all(),'id','name'),
        'options' => ['placeholder' => 'Выберите задание ...',
              'onchange'=>'
                $.post( "'.Url::to(['//task/givepreview','id' => '']).'"+$(this).val(), function( data ) {
                  $( "#givepreview" ).html( data );
                }); ',],
        'pluginOptions' => [
            'tags' => true,            
        ],
    ]);
    ?>
    
    <?= Html::tag('br')?>
    
    <div class="panel panel-default">
        <div class='panel-heading'>Текст задания</div>
        <div class='panel-body'  id="givepreview" ><?=  Markdown::process($model->task->text)?></div>
    </div>
    
    <?= Html::label('Тип упражнений')?>
    <?= Select2::widget([
        'name' => 'exersice_type',
        'id' => 'exersice_type',  
        'value' => ArrayHelper::getColumn(ExerciseSubject::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id'),
        'data' => ArrayHelper::map(ExerciseSubject::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id','name'),
        'options' => ['placeholder' => 'Выберите типы упражений ...',  'multiple' => true, 'onchange'=>'
                var arr = []; 
                $("#exersice_type :selected").each(function(i, selected){ 
                  arr[i] = $(selected).val(); 
                });
                $.post( "'.Url::to(['//exercise/exersicelistbytype','id' => '']).'"+arr, function( data ) {
                  $( "#exersices" ).html( data );
                });
            '],
        'pluginOptions' => [
            'tags' => true,
        ],
    ]); ?>
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Упражнения')?>
    
    <?= Select2::widget([
        'name' => 'exersices',
        'id' => 'exersices', 
        'value' => ArrayHelper::getColumn($model->exercises,'exercise.id'),
        'data' => ArrayHelper::map(Exercise::find()->where(['subject_id' => 
         ArrayHelper::getColumn(ExerciseSubject::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id')])->all(),'id','name'),
        'options' => ['placeholder' => 'Select a color ...', 'multiple' => true, 'onchange'=>'
                var arr = []; 
                $("#exersices :selected").each(function(i, selected){ 
                  arr[i] = $(selected).val(); 
                });               
                $.post( "'.Url::to(['//task/exersicespreview','list' => '']).'"+arr, function( data ) {
                  $( "#exersicespreview" ).html( data );
                });
            '],
        'pluginOptions' => [
            'tags' => true,
        ],
    ]);?>    
    
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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>        
    
     <?php if($result)
            echo Html::tag('div','Обновлено!',['class' => 'alert alert-success']); ?>
    
    <?php ActiveForm::end(); ?>
    
    <?php  Pjax::end(); ?>
</div>