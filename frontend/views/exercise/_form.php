<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ExerciseSubject;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Exercise */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exercise-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'teacher_id')->textInput() ?>
    
    <?= $form->field($model, 'subject_id')->dropDownList(ArrayHelper::map(ExerciseSubject::find()
            ->where(['teacher_id' => Yii::$app->user->identity->teacher->id])->all(),'id','name')) ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    
    <?php $this->registerJs(" $('#exercise-text').markItUp(myTextileSettings);  ");  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
