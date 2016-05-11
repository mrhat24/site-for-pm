<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TaskType;
use kartik\markdown\MarkdownEditor;
/* @var $this yii\web\View */
/* @var $model common\models\Task */
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

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput()?>
    <?= $form->field($model, 'type_id')->dropDownList(TaskType::typeList())?>
    <?= $form->field($model, 'text')->widget(MarkdownEditor::className(),
            ['smarty' => true,'showExport' => 0, 'footerMessage' => '<p>Введите формулу в формате latex: <span id="math-field"></span></p>
    <p>Результат: <span id="formula"><span id="latex"></span></span></p><p>При копировании в текст заключайте формулу в двойные знаки доллара $$<span>формула</span>$$</p>
    <p><a href="https://ru.wikipedia.org/wiki/%D0%92%D0%B8%D0%BA%D0%B8%D0%BF%D0%B5%D0%B4%D0%B8%D1%8F:%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B" target="_blank">Примеры формул на Wikipedia</a></p>'
                ]) ?>  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
