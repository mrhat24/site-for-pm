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

    <?= Html::tag('blockquote',$parser->textileThis($model->givenTask->task->text)) ?>
    

    <?/*= $form->field($model, 'result')->dropDownList(['0' => '','2' => 'Неудовлетворительно','3' => 'Удовлетворительно',
        '4' => 'Хорошо', '5' => 'Отлично']) */?>

    <?=  Html::tag('blockquote',$parser->textileThis($model->comment));?>   
    
    <?= Html::tag('p','Дата выдачи задания: '.DateHelper::getDateByUserTimezone($model->givenTask->date),['class' => 'alert alert-info']); ?>
        
    <?=Html::tag('hr')?>
        
    <div class="exersices-list">
        <?=Html::tag('h3','Упражнения')?>        
        <?php
            foreach ($exersices as $exers)
            {
                echo Html::tag('blockquote','Задание: '.$exers->exercise->text.Html::tag('blockquote','Решение: '.$exers->text));
                //echo ;

                echo $form->field($exers,"[$exers->id]comment")->textarea(['rows' => 4]);
                echo $form->field($exers,"[$exers->id]result")->dropDownList(['0' => '','2' => 'Неудовлетворительно','3' => 'Удовлетворительно',
        '4' => 'Хорошо', '5' => 'Отлично']);
                echo $form->field($exers,"[$exers->id]remake")->checkbox();
            }
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
</div>