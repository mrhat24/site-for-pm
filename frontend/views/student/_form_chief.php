<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\User;
use kartik\select2\Select2;
use common\models\Group;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="student-form">
    <?php Pjax::begin() ?>
    <?php $form = ActiveForm::begin(['id'=>'project-form']); ?>
        
    
    <?= $model->isNewRecord ? $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(User::find()->all(),'id','usernameFullname'),        
        'options' => ['placeholder' => 'Введите Ф.И.О...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) : '';
    ?>
    
    <?= $form->field($model, 'group_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Group::find()->all(),'id','name'),        
        'options' => ['placeholder' => 'Введите название группы...'],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>
    
    <?= $form->field($model, 'education_start_date')->widget(DatePicker::classname(), [
        'clientOptions' => [
            'changeMonth' => true,           
            'changeYear' => true,                 
            'yearRange' => "-100:+100",
        ],
        'options' => ['class' => 'form-control']
        
]) ?>

    <?= $form->field($model, 'education_end_date')->widget(DatePicker::classname(), [
        'clientOptions' => [
            'changeMonth' => true,           
            'changeYear' => true,            
            'yearRange' => "-100:+100",
        ],
        'options' => ['class' => 'form-control']
        
]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php    Pjax::end(); ?>
</div>
