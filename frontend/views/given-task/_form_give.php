<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TaskType;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use common\models\Group;
use common\models\ExerciseSubject;
use kartik\date\DatePicker;
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
    
    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['data-pjax' => true ]]); ?>

    <?= Html::tag('br')?>
    
    <?= Html::label('Дисциплина')?>
    
    <?= Html::dropDownList('discipline','',ArrayHelper::map(Yii::$app->user->identity->teacher->teacherHasDiscipline,'groupHasDiscipline.discipline.id','groupHasDiscipline.discipline.name'), 
             [
                'prompt'=>'-Выберите преподаваемую дисциплину-',
                'onchange'=>'
                    $.post( "'.Yii::$app->urlManager->createUrl('group/lists?id=').'"+$(this).val(), function( data ) {
                      $( "select#group_list" ).html( data );
                    });
                ',
            'class' => 'form-control',
            'id' => 'discipline_list',     
                 ]); ?>
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Группа')?>
    
    <?= Html::dropDownList('group','',[], 
             ['prompt'=>'-Выберите группу-',
              'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('student/lists?id=').'"+$(this).val(), function( data ) {
                  $( "select#student_list" ).html( data );
                });
            ','class' => 'form-control',
             'id' => 'group_list',]); ?>
    
    <?= Html::tag('br')?>

    <?= Html::label('Студенты')?>
    
    <?= Html::button('Выделить всех',['onclick' => 
        '$("#student_list option").prop("selected",true);',
        'class' => 'btn btn-primary btn-xs'
        ])?>
           
    <?= Html::listBox('students','',[], 
             ['class' => 'form-control',
             'id' => 'student_list',
             'multiple' => 'true'    
                 ]); ?> 
    
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Тип задания')?>
    
    <?= Html::dropDownList('task_type','',ArrayHelper::map(TaskType::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id','name'), 
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
    
    <?= Html::dropDownList('task','',[], 
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
             <div class='panel-body'  id="givepreview" ></div>
    </div>
    
    <?= Html::label('Тип упражнений')?>
    
    <?= Html::button('Выделить все',['onclick' => 
        '$("#exersice_type option").prop("selected",true); $("#exersice_type option").trigger("change");',
        'class' => 'btn btn-primary btn-xs'
        ])?>
    
    <?= Html::listBox('exersice_type','',ArrayHelper::map(ExerciseSubject::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id','name'), 
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
    
     <?= Html::listBox('exersices',null,[], 
             [
                'class' => 'form-control',
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
             <div class='panel-body'  id="exersicespreview" ></div>
    </div>
    
    <?//= $form->field($model, 'given_date')->widget(DatePicker::className()) ?>
    
    <?//= $form->field($model, 'deadline_date')->widget(DatePicker::className()) ?>
    
    <?//= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    
    <?php $this->registerJs(" $('#task-text').markItUp(myTextileSettings);  ");  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>        
    <?php ActiveForm::end(); ?>
    
    <?php  Pjax::end(); ?>
</div>