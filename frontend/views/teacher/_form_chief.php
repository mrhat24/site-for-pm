<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
/* @var $this yii\web\View */
/* @var $model common\models\Teacher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="teacher-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $model->isNewRecord ? $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(),'id','fullname','username')) : "";?>
    
    <?= $form->field($model, 'post')->textarea() ?>
    
    <?= $form->field($model, 'academic_degree')->textarea() ?>    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
