<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\WorkList */
/* @var $form yii\widgets\ActiveForm */
?>

<?php Pjax::begin(['id' => 'modalContent','enablePushState' => false]); ?>
<div class="work-list-form">

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>   

    <div class="form-group">
        <?= Html::button($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'type' => 'submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end(); ?>