<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TaskType;
use ijackua\lepture\Markdowneditor;
/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput()?>
    <?= $form->field($model, 'type_id')->dropDownList(TaskType::typeList())?>
    <?= $form->field($model, 'text')->widget(Markdowneditor::className())?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
