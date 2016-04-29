<?php

use yii\helpers\Html;
use common\models\Group;
use yii\helpers\Url;
use yii\bootstrap\Tabs;
use yii\helpers\Markdown;

$this->registerJs("        
        $('.list-group-item span').on('click',function(e) { if (e.target != this) { return true; } if (e.target == this) { 
            $(this).children('.glyphicon').toggleClass('glyphicon-chevron-right').toggleClass('glyphicon-chevron-down');
            $(this).toggleClass('list-group-item-info');
            $(this).next('div.list-group').toggle(100); }  
        });         
");
echo Html::beginTag('div',['class' => 'well well-sm']);
?>
                <div class="btn-group">
                    <?=Html::a('<i class="glyphicon glyphicon-briefcase"></i> Страница группы',Url::to(['//group/view',
                        'id' => $group->id]),['class' => 'btn btn-primary']); ?>
                </div>
<div class="list-group">
    <div class="list-group-item">            
                <h4>Ваши объявления</h4>
                <div class="btn-group">
                    <?=Html::button('<i class="glyphicon glyphicon-envelope"></i> Добавить объявление',['value'=> Url::to(['//group/create-anounce',
                    'id' => $group->id]), 'class' => 'btn btn-primary modalButton']); ?>
                </div>
        <?php //Список объявлений
            $anounces = Yii::$app->user->identity->teacher->anounces;
            foreach ($anounces as $anounce){
                $btnUrl = Url::to(['//group/update-anounce','id' => $anounce->id]);
                $dateTime = Yii::$app->formatter->asDateTime($anounce->date);
                $deleteBtn = Html::a('<i class="glyphicon glyphicon-remove"></i>',  Url::to(['//group/delete-anounce','id' => $anounce->id]),['title' => Yii::t('yii', 'Delete'),
                    'aria-label' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Вы уверены что хотите это удалить?'),
                    'data-method' => 'post',
                    'value'=> $btnUrl,
                    'class' => 'btn btn-xs btn-default',]);
                echo "<span class='list-group-item'><i class='glyphicon glyphicon-chevron-right'></i>{$dateTime}
                    <button type='button' class='btn btn-default btn-xs modalButton' value='{$btnUrl}'>
                    <span class='glyphicon glyphicon glyphicon-pencil'></span>                    
                    </button>{$deleteBtn}</span>";
                echo "<div class='list-group well' style='display: none;'>";                                       
                        echo Html::tag('div',Markdown::process($anounce->text));        
                echo "</div>";
                
            //echo Html::tag('div',Markdown::process($anounce->text),['class' => 'alert']);
            }
        ?>          
    </div>    
</div>
<?php
//Список студентов
    $menuItems = [];
    $formatter = Yii::$app->formatter;
?>
<div class="list-group">
    <div class="list-group-item">
        <h4>Список студентов</h4>
        <?php
            foreach($group->students as $student) {
            $isSteward = $student->isSteward ? ' - Староста' : '';
            echo "<span class='list-group-item'><i class='glyphicon glyphicon-chevron-right'></i>{$student->user->fullname}{$isSteward}</span>";
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
                        echo Html::a($task->task->name." - ".$formatter->asDatetime($task->given_date)." Статус: {$task->statusIdentity['rus']}",'#', [
                                    'class' => 'modalButton',
                                    'value'=>Url::to(['/given-task/check','id' => $task->id]) ]
                        );
                        echo "</div>";
                    }         
                echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>
<?php
    
    /*echo Html::beginTag('div',['class' => 'list-group']);
        echo Html::beginTag('div',['class' => 'list-group-item']);
        echo Html::tag('h4','Список студентов');
        
        echo Html::endTag('div');
    echo Html::endTag('div');*/
//Конец список студентов    

echo Html::endTag('div');    
