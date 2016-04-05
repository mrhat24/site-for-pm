<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\Standart */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="standart-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
        'clientOptions' => [
            'changeMonth' => true,           
            'changeYear' => true,            
            'yearRange' => "-100:+100",
        ],
        'options' => ['class' => 'form-control']
        
]) ?>
    
    <?= $form->field($model, 'key')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
