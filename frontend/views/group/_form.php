<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\jui\Spinner;
use yii\helpers\ArrayHelper;
use common\models\Speciality;
use yii\jui\SliderInput;
/* @var $this yii\web\View */
/* @var $model common\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true ]) ?>

    <?= $form->field($model, 'speciality_id')->dropDownList(ArrayHelper::map(Speciality::find()->all(),'id','name'))//->widget(DatePicker::className(),['clientOptions' => ['defaultDate' => '2014-01-01']]) ?>
    <div class="form-group">
        <?= Html::label('Количество семестров') ?>
        <?= Html::tag('span',null,['id' => 'sem_count_label']); ?>
        
        <?php        
        
        echo Spinner::widget([
            'name'  => 'sem_count',
            'id' => 'sem_count',
            'value' => 8,
            'clientOptions' => ['step' => 1],
        ]);
        ?> 
    </div>
    <div class="form-group">
        <?= Html::label('Год начала обучения') ?>
        <?php
        echo Spinner::widget([
                'name'  => 'begin_year',
                'id' => 'begin_year',
            'value' => date("Y"),
            'clientOptions' => ['step' => 1],
        ]);            
        ?>
    </div>
    
    
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
