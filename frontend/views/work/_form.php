<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Work;
/* @var $this yii\web\View */
/* @var $model common\models\Work */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'work_type_id')->textInput() ?>

    <?//= $form->field($model, 'name')->textInput() ?>

    <?//= $form->field($model, 'student_id')->textInput() ?>

    <?//= $form->field($model, 'teacher_id')->textInput() ?>

    <?//= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'approve_status')->dropDownList(ArrayHelper::map(Work::getStatusList(),'id','name'))->label('Статус'); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
