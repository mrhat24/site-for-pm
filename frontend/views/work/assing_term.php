<?php

use yii\bootstrap\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Student;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
?>

<div class="assing-term-form">        
    
<?php 
Pjax::begin(['enablePushState' => false, 'id' => 'form-give-term']);
    $form = ActiveForm::begin([
        'id' => 'assing_term_form',        
    ]);
    echo $form->field($model2,'discipline')->dropDownList(ArrayHelper::map(Yii::$app->user->identity->teacher->disciplineList,'id','name')
            ,['prompt'=>'-Выберите дисциплину-','id' => 'discipline-id'])->label('Дисциплина');
    echo $form->field($model2,'group')->widget(DepDrop::classname(), [
    'options'=>['id'=>'subcat-id'],
    'pluginOptions'=>[
        'depends'=>['discipline-id'],
        'placeholder'=>'Select...',
        'url'=>Url::to(['/work/groupfromdiscipline'])
    ]
])->label('Группа');
    
    echo $form->field($model2,'student_id')->widget(DepDrop::classname(), [
    'options'=>['id'=>'subcat2-id'],
    'pluginOptions'=>[
        'depends'=>['subcat-id'],
        'placeholder'=>'Select...',
        'url'=>Url::to(['/work/studentfromgroup'])
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
