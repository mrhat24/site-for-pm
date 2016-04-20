<?php

use yii\helpers\Html;
use common\models\Group;
use yii\helpers\Url;
use yii\bootstrap\Tabs;

$this->registerJs("        
        $('.list-group-item span').on('click',function(e) { if (e.target != this) { return true; } if (e.target == this) { 
            $(this).children('.glyphicon').toggleClass('glyphicon-chevron-right').toggleClass('glyphicon-chevron-down');
            $(this).toggleClass('list-group-item-info');
            $(this).next('div.list-group').toggle(100); }  
        });         
");
echo Html::beginTag('div',['class' => 'well']);
echo Html::tag('h4','Список студентов');
    $menuItems = [];    
    $formatter = Yii::$app->formatter;    
    echo Html::beginTag('div',['class' => 'list-group']);
        echo Html::beginTag('div',['class' => 'list-group-item']);
        foreach($group->students as $student) {
            echo "<span class='list-group-item'><i class='glyphicon glyphicon-chevron-right'></i>{$student->user->fullname}</span>";
            echo "<div class='list-group well' style='display: none;'>";
                echo Html::beginTag('div',['class' => 'btn-group']);
                echo Html::button('<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Сообщение',
                        ['class' => 'btn btn-primary modalButton','value'=> Url::to(['message/create','id' => $student->user->id])] );
                echo Html::button('<span class="glyphicon glyphicon-user" aria-hidden="true"></span> Профиль пользователя',
                        ['class' => 'btn btn-primary modalButton','value'=> Url::to(['user/view','id' => $student->user->id])] );
                echo Html::button('<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Профиль студента',
                        ['class' => 'btn btn-primary modalButton','value'=> Url::to(['student/view','id' => $student->id])] );
                echo Html::endTag('div');
                echo "<span class='list-group-item'><i class='glyphicon glyphicon-chevron-right'></i>Задания</span>";
                echo Html::beginTag('div',['class' => 'list-group','style' => 'display:none;']);
                    foreach($student->givenTasks as $task) {
                        echo Html::beginTag('div',['class' => "list-group-item list-group-item-{$task->statusIdentity['ident']}"]);
                        echo Html::a($task->task->name." - ".$formatter->asDatetime($task->given_date)." Статус: {$task->statusIdentity['rus']}",'#',
                                ['class' => 'modalButton',
                                    'value'=>Url::to(['/given-task/check','id' => $task->id])]);
                        echo "</div>";
                    }         
                echo "</div>";
            echo "</div>";
        }
        echo Html::endTag('div');
    echo Html::endTag('div');
echo Html::endTag('div');    
