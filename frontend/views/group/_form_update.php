<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\jui\Spinner;
use yii\helpers\ArrayHelper;
use common\models\Speciality;
use common\models\Student;
/* @var $this yii\web\View */
/* @var $model common\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true ]) ?>

    <?= $form->field($model, 'speciality_id')->dropDownList(ArrayHelper::map(Speciality::find()->all(),'id','name'))//->widget(DatePicker::className(),['clientOptions' => ['defaultDate' => '2014-01-01']]) ?>
    
    <?= $form->field($model, 'steward_student_id')->dropDownList(ArrayHelper::map(Student::find()->where(['group_id' => $model->id])->all(),'id','user.fullname'),['prompt' => '-- Выберите студента --']); ?>
        
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
