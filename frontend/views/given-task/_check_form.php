<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\components\DateHelper;
use yii\widgets\Pjax;
use Netcarver\Textile;
$parser = new \Netcarver\Textile\Parser();
/* @var $this yii\web\View */
/* @var $model common\models\CompleteTask */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs('$("#form-task").on("pjax:end", function(){
 $("#modal").modal("hide")});');
    ?>

<div class="complete-task-form">
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'form-task']) ?>

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>

    <?//= $form->field($model, 'given_task_id')->textInput() ?>

    <?php
            echo Html::beginTag('div',['class' => 'panel panel-info']);
            echo Html::tag('div','Текст задания',['class' => 'panel-heading']);
            echo Html::tag('div',$parser->textileThis($model->task->text),['class' => 'panel-body']);
            echo Html::endTag('div');
    ?>

    <?= $form->field($model, 'result')->dropDownList(['0' => '','2' => 'Неудовлетворительно','3' => 'Удовлетворительно',
        '4' => 'Хорошо', '5' => 'Отлично']) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'status')->dropDownList(['0' => 'Не решено','1' => 'Отправлено на проверку',
        '2' => 'Есть нарекания','3' => 'Завершено']) ?>
    
    <?= 'Дата последнего редактирования: '.Html::tag('span',  DateHelper::getDateByUserTimezone($model->given_date)) ?>
    <?=Html::tag('hr')?>
    <div class="exersices-list">
        <?php
            echo Html::tag('h2','Задания',['class' => 'panel-heading']);
            echo Html::tag('hr');
            $index = 0;
            foreach ($exercises as $key => $exers)
            {
                $index++;
                
                echo Html::tag('h4','Задание#'.$index,['class' => 'panel-heading']);
                
                echo Html::beginTag('div',['class' => 'panel panel-info']);
                echo Html::tag('div','Текст',['class' => 'panel-heading']);
                echo Html::tag('div',$parser->textileThis($exers->exercise->text),['class' => 'panel-body']);
                echo Html::endTag('div');
                
                echo Html::beginTag('div',['class' => 'panel panel-info']);
                echo Html::tag('div','Решение',['class' => 'panel-heading']);
                echo Html::tag('div',$parser->textileThis($exers->solution),['class' => 'panel-body']);
                echo Html::endTag('div');
                
                echo $form->field($exers,"[$exers->id]comment")->textarea(['rows' => 4]);
                echo $form->field($exers,"[$exers->id]result")->dropDownList(['0' => '','2' => 'Неудовлетворительно','3' => 'Удовлетворительно',
        '4' => 'Хорошо', '5' => 'Отлично']);
                echo $form->field($exers,"[$exers->id]remake")->checkbox();
                 echo Html::tag('hr');
            }
            
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>