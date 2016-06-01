<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TaskType;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Group;
use common\models\ExerciseSubject;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
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

    <?php 
        echo Select2::widget([
        'name' => 'discipline',
        'id' => 'discipline_list',               
        'data' => ArrayHelper::map(Yii::$app->user->identity->teacher->teacherHasDiscipline,'groupHasDiscipline.id','groupHasDiscipline.discSem'),
        'options' => [ 'placeholder' => 'Выберите дисциплину ...' ],
        'pluginOptions' => [
            'tags' => true,            
        ],
    ]);
    ?>
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Группа')?>
    <?php 
    
    echo DepDrop::widget([
            'name' => 'group',
            'id' => 'group_list',   
            'options' => ['placeholder' => 'Группа ...'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['discipline_list'],
                'url' => Url::to(['//group/lists']),
                'loadingText' => 'Загрузка групп ...',
            ]
        ]);
        /*echo Select2::widget([
        'name' => 'group',
        'id' => 'group_list',               
        'options' => ['placeholder' => 'Выберите группу ...',
              'onchange'=>'
                $.post( "'.Url::to(['//student/lists','id' => '']).'"+$(this).val(), function( data ) {
                  $( "select#student_list" ).html( data );
                }); ',],
        'pluginOptions' => [
            'tags' => true,            
        ],
    ]);*/
    ?>

    
    <?= Html::tag('br')?>

    <?= Html::label('Студенты')?>   
    <?php
    echo DepDrop::widget([
            'name' => 'students',
            'id' => 'student_list',              
            'options' => ['placeholder' => 'Студенты ...', 'multiple' => true],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                'depends'=>['group_list'],
                'url' => Url::to(['//student/lists']),
                'loadingText' => 'Загрузка студентов ...',
            ]
        ]);
    ?>
    <?php /*echo  Select2::widget([
        'name' => 'students',
        'id' => 'student_list',     
        'options' => ['placeholder' => 'Выберите студентов ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]); */ ?>
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Тип задания')?>
    
    <?php 
        echo Select2::widget([
        'name' => 'task_type',
        'id' => 'task_type',    
        'data' => ArrayHelper::map(TaskType::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id','name'),
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
             <div class='panel-body'  id="givepreview" ></div>
    </div>
    
    <?= Html::label('Тип упражнений')?>
    
    <?= Select2::widget([
        'name' => 'exersice_type',
        'id' => 'exersice_type',     
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
            'maximumInputLength' => 10
        ],
    ]); ?>
    
    <?= Html::tag('br')?>
    
    <?= Html::label('Упражнения')?>
    
    <?= Select2::widget([
        'name' => 'exersices',
        'id' => 'exersices',     
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
            'maximumInputLength' => 10
        ],
    ]);?>
    
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