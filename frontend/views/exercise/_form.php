<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ExerciseSubject;
use yii\helpers\ArrayHelper;
use unclead\widgets\MultipleInput;
use kartik\markdown\MarkdownEditor;
use common\components\MdEditorHelp;
$this->registerJs(MdEditorHelp::getJsMath());

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
    
    <?= $form->field($model, 'text')->widget(MarkdownEditor::className(),MdEditorHelp::getMdParamsWithMath()) ?>  
    
    <?= $form->field($model, 'test')->checkbox() ?>
    
    <?php
    echo $form->field($model, 'exerciseTests')->widget(MultipleInput::className(),  [
        'addButtonPosition' => MultipleInput::POS_HEADER,
        'min' => 0,
        'columns' => [
        [
            'name'  => 'id',
            'type'  => 'hiddenInput',            
        ],
        [
            'name'  => 'value',
            'type'  => 'textInput',
            'title' => 'Ответ',           
        ],
        [
            'name'  => 'istrue',
            'type'  => 'checkbox',
            'title' => 'Правильный',             
        ],
    ]]);
    //->label('');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
