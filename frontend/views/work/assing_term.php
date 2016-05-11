<?php

use yii\bootstrap\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
?>

<div class="assing-term-form">        
    
<?php 
Pjax::begin(['enablePushState' => false, 'id' => 'form-give-term']);
    $form = ActiveForm::begin([
        'id' => 'assing_term_form',
    ]);
    echo $form->field($model,'ghd_id')->dropDownList(ArrayHelper::map(Yii::$app->user->identity->teacher->teacherHasDiscipline,'groupHasDiscipline.id','groupHasDiscipline.discGroupSem'),[
        'prompt'=>'-Выберите дисциплину -',
        'id' => 'ghdcat-id'])->label('Дисциплина');
    
   /* echo $form->field($model2,'group')->widget(DepDrop::classname(), [
    'options'=>['id'=>'subcat-id'],
    'pluginOptions'=>[
            'depends'=>['ghdcat-id'],
            'placeholder'=>'Select...',
            'url'=>Url::to(['/work/groupfromdiscipline'])
        ]
    ])->label('Группа'); */
    
    echo $form->field($model,'student_id')->widget(DepDrop::classname(), [
    //'options'=>['id'=>'subcat2-id'],
    'pluginOptions'=>[
        'depends'=>['ghdcat-id'],
        'placeholder'=>'Select...',
        'url'=>Url::to(['/work/studentfromghd'])
    ]
])->label('Студент');
    
    ?>
    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php
    ActiveForm::end();
    
    
Pjax::end(); 
?>    
    
</div>
