<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\components\DateHelper;
use yii\widgets\Pjax;
use Netcarver\Textile;
$parser = new \Netcarver\Textile\Parser();
use yii\helpers\ArrayHelper;
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
    <div class='well well-sm'>
    <?php
            echo Html::tag('h5','Студент: '.$model->student->user->fullname);
            echo Html::tag('h5','Группа: '.$model->student->group->name);
            echo Html::tag('h5','Дисциплина: '.$model->disciplineName);
    ?>
    </div>
    <?php
            echo Html::beginTag('div',['class' => 'panel panel-info']);
            echo Html::tag('div',$model->task->name,['class' => 'panel-heading']);
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
                if($exers->exercise->exerciseTests){                    
                    
                    echo Html::beginTag('ul',['class' => 'list-group']);                    
                    if($exers->answerIsTrue) echo '<li class="list-group-item list-group-item-success">Выбран правильный ответ</li>';
                    else echo '<li class="list-group-item list-group-item-danger">Выбран не правильный ответ</li>';
                    foreach($exers->exercise->exerciseTests as $test){
                        $success = '';
                        $badge = "";
                        if($test->istrue){
                            $badge = $badge."<span class='badge'>Правильный ответ</span>";
                        }                            
                        if(in_array($test->id, $exers->answers))
                        {
                            $badge = $badge."<span class='badge'>Выбранный ответ</span>";
                            if(in_array($test->id, $exers->exercise->exerciseTestsTrue))
                            {                           
                                $success = 'list-group-item-success';
                            }
                            else{
                                $success = 'list-group-item-warning';
                            }
                        }
                        echo Html::tag('li',$test->value.$badge,['class' => "list-group-item {$success}"]);
                    }
                    echo Html::endTag('ul');
                                    
                }
                else 
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