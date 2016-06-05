<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
//variables
$student = Yii::$app->user->identity->student;
$formatter = Yii::$app->formatter;

$this->beginBlock('info');
?>
    <div class="list-group">
        <dl class="dl-horizontal">
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Ф.И.О.");
                echo Html::tag('dd',Html::button($student->user->fullname,['value' => Url::to(['//user/view','id' => $student->user->id]),'class' => 'btn btn-xs btn-link modalButton']));
            ?></div>
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Номер зачетки");
                echo Html::tag('dd',$student->srb);
            ?></div>
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Дата начала обучения");
                echo Html::tag('dd',$formatter->asDate($student->education_start_date));
            ?></div>
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Группа");
                echo Html::tag('dd',Html::a($student->group->name,Url::to(['//group/my'])));
            ?></div>
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Текущий семестр");
                echo Html::tag('dd',$student->group->currentSemesterNumber);
            ?></div>
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Специальность");
                echo Html::tag('dd',$student->group->speciality->name);
            ?></div>
        </dl>
    </div>    
<?php
$this->endBlock('info');

$this->beginBlock('stat');
?>
    <div class="list-group">
            <?php
                echo "<div class='list-group-item list-group-item-info'><span class='badge'>{$student->gpa}</span>Средний балл</div>";
                foreach($student->taskStat as $stat){
                    if(Yii::$app->user->identity->student->tasksCount)
                        $taskPercent = round(($stat['value']/$student->tasksCount)*100,2);
                    else $taskPercent = $student->tasksCount;
                    echo "<div class='list-group-item '><span class='badge'>{$stat['value']} ({$taskPercent}%)</span>{$stat['status']}</div>";
                }
                echo "<div class='list-group-item list-group-item-info'><span class='badge'>{$student->tasksCount}</span>Всего получено заданий</div>";
                
            ?>
    </div>    
<?php
$this->endBlock('stat');

echo Tabs::widget([
        'options' => ['class' => 'nav nav-pills nav-justified'],        
        'items' => [
            [
            'label' => 'Личные данные',
            'content' => $this->blocks['info'],            
            ],
            [
            'label' => 'Статистика заданий',
            'content' => $this->blocks['stat'],            
            ]
        ]
    ]); 
?>

