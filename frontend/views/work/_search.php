<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\WorkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'work_type_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'teacher_id') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'approve_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
