<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;


//variables
$student = Yii::$app->user->identity->student;
$formatter = Yii::$app->formatter;

$this->beginBlock('info');
?>
<div class="well well-sm">
    <div class="list-group">
        <dl class="dl-horizontal">
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Ф.И.О.");
                echo Html::tag('dd',$student->user->fullname);
            ?></div>
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Дата начала обучения");
                echo Html::tag('dd',$formatter->asDate($student->education_start_date));
            ?></div>
            <div class="list-group-item"><?php
                echo Html::tag('dt',"Группа");
                echo Html::tag('dd',$student->group->name);
            ?></div>
        </dl>
    </div>   
</div>    
<?php
$this->endBlock('info');

$this->beginBlock('stat');
?>
<div class="well well-sm">
    <div class="list-group">
        <dl class="dl-horizontal">
            <?php
                foreach($student->taskStat as $stat){
                    echo "<div class='list-group-item'><dt>{$stat['status']}</dt><dd>{$stat['value']}</dd></div>";
                }
            ?>
        </dl>
    </div>            
</div>
<?php
$this->endBlock('stat');

echo Tabs::widget([
        'options' => ['class' => 'nav nav-pills nav-justified'],
        'items' => [
            [
            'label' => 'Информация',
            'content' => $this->blocks['info'],            
            ],
            [
            'label' => 'Статистика заданий',
            'content' => $this->blocks['stat'],            
            ]
        ]
    ]); 
?>

