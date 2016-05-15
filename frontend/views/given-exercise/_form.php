<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax; 
use common\widgets\markdown\MarkdownEditor;
/* @var $this yii\web\View */
/* @var $model common\models\CompleteExercise */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs("var mathFieldSpan = document.getElementById('math-field');
    var latexSpan = document.getElementById('latex');
    var MQ = MathQuill.getInterface(2); // for backcompat
    var mathField = MQ.MathField(mathFieldSpan, {
      spaceBehavesLikeTab: true, // configurable
      handlers: {
        edit: function() { // useful event handlers
          latexSpan.textContent = mathField.latex(); // simple API
        }
      }
    });");
?>


<div class="complete-exercise-form">

     <?php   
     $this->registerJs('$("#form-exersice").on("pjax:end", function(){
                 $("#modal").modal("hide")});');
    ?>
    
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'form-exersice']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
    <?= Html::tag('p',$model->exercise->text,['class' => 'alert alert-info']); ?>     
    <?php
            
        if($model->exercise->exerciseTests){
            $checkboxes = Html::checkboxList('answers',$model->answers,\yii\helpers\ArrayHelper::map($model->exercise->exerciseTests, 'id','value'),['separator' => '<br>']);           
            echo Html::tag('div',$checkboxes,['class' => 'well well-sm']);
        }
        else {
            echo $form->field($model, 'solution')->widget(MarkdownEditor::className(),
                ['smarty' => true,'showExport' => 0, 'footerMessage' => '<p>Введите формулу в формате latex: <span id="math-field"></span></p>
    <p>Результат: <span id="formula"><span id="latex"></span></span></p><p>При копировании в текст заключайте формулу в двойные знаки доллара $$<span>формула</span>$$</p>
    <p><a href="https://ru.wikipedia.org/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D0%BF%D0%B5%D0%B4%D0%B8%D1%8F:%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B" target="_blank">Примеры формул на Wikipedia</a></p>'
                ]);
        }
    ?>
    

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php  Pjax::end(); ?>
    

</div>
