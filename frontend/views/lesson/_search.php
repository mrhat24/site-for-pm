<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\LessonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lesson-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ghd_id') ?>

    <?= $form->field($model, 'lesson_type_id') ?>

    <?= $form->field($model, 'teacher_id') ?>

    <?= $form->field($model, 'week') ?>

    <?php // echo $form->field($model, 'day') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'auditory') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
