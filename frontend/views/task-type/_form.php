<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\TaskType */
/* @var $form yii\widgets\ActiveForm */
?>

<?php Pjax::begin(['id' => 'modalContent','enablePushState' => false]); ?>
<div class="task-type-form">

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::button($model->isNewRecord ? 'Создать' : 'Сохранить', 
                [
                    'value' => $model->isNewRecord ? 
                        Url::to(['task-type/create']) : Url::to(['task-type/update']),
                    'class' => $model->isNewRecord ? 
                        'btn btn-success modalButton' : 'btn btn-primary  modalButton',
                    'type' => 'submit'
                ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
   <?php Pjax::end(); ?>