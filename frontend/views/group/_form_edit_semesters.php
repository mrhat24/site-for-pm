<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\jui\Spinner;
use yii\helpers\ArrayHelper;
use common\models\Speciality;
/* @var $this yii\web\View */
/* @var $model common\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php
        foreach($modelGS as $key => $gs)
        {
    ?>
        <div class="panel panel-primary">
            <div class="panel-heading">     
        <?= 'Семестр : '.$gs->semester_number; ?>
            </div>
            <div class="panel-body">
    <?php
            echo $form->field($gs, "[$key]begin_date")
                    ->widget(DatePicker::className(),['options' => ['class' => 'form-control'],
                        'dateFormat' => 'dd-MM-yyyy','language' => 'ru']);
            echo $form->field($gs, "[$key]end_date")
                    ->widget(DatePicker::className(),['options'=> ['class' => 'form-control'],'dateFormat' => 'dd-MM-yyyy','language' => 'ru']);
    ?>
            </div>
        </div>
    <?php
        }
    ?>
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
