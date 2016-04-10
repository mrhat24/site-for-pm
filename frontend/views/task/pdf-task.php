<?php

/*
 * var $model
 */
use yii\helpers\Html;
use common\components\DateHelper;
use Netcarver\Textile;
$parser = new \Netcarver\Textile\Parser();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<h1 style="text-align: center;"><?= Html::encode($model->task->name) ?></h1></hr>
<?php
    echo "<br>";
    echo Html::tag("h6",'Дата выдачи задания: '.Yii::$app->formatter->asDatetime($model->given_date),['class' => 'date', 'style'=> "text-align: right;"]);
    echo Html::tag("h6",'Преподаватель: '.$model->teacher->user->fullname,['class' => 'date', 'style'=> "text-align: right;"]);
    echo Html::tag("h6",'Студент: '.$model->student->user->fullname,['class' => 'date', 'style'=> "text-align: right;"]);
    echo Html::tag("h6",'Группа: '.$model->student->group->name,['class' => 'date', 'style'=> "text-align: right;"]);
    echo $parser->textileThis($model->task->text);
    echo "<br>";
    echo '<h2 style="text-align: center;">Задания</h2>';
    $counter = 1;    
    foreach($model->exercises as $exercise){
        ?>
<div class="panel panel-success">
        <?php
        echo '<div class="panel-heading">';
        echo Html::tag('h4',$counter.". ".$exercise->exercise->name);
        echo '</div>';
        echo '<div class="panel-body">';
        echo $exercise->exercise->text;
        echo '</div>';
        $counter++;
        ?>
</div>
    <?php
    }       
?>