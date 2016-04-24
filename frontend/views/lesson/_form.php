<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\GroupHasDiscipline;
use common\models\LessonType;
use common\models\Lesson;
use kartik\time\TimePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Lesson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lesson-form">

    <?php $form = ActiveForm::begin(); ?>
 
    
    <?= $form->field($model, 'ghd_id')->dropDownList(ArrayHelper::map(GroupHasDiscipline::find()->all(),'id','groupSemDisc')); ?>    

    <?= $form->field($model, 'thd_id')->widget(DepDrop::classname(), [
    'options'=>['id'=>'thd_id-id'],    
    'pluginOptions'=>[
        'depends'=>['lesson-ghd_id'],
        'placeholder'=>'...',
        'url'=>Url::to(['/lesson/thd'])
    ]
]); ?>
    
    <?= $form->field($model, 'lesson_type_id')->dropDownList(ArrayHelper::map(LessonType::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'week')->dropDownList(['1' => 1, '2' => 2]) ?>

    <?= $form->field($model, 'day')->dropDownList(Lesson::getDaysList()) ?>

    <?= $form->field($model, 'time')->widget(TimePicker::classname(), ['pluginOptions' => 
        ['defaultTime' => '8:30:00',
            'showSeconds' => true,
            'showMeridian' => false,
            'minuteStep' => 5]]); ?>

    <?= $form->field($model, 'auditory')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', 
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
