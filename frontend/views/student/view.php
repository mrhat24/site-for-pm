<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Student */
$student = $model;
$formatter = Yii::$app->formatter;

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>
    <div class="btn-group">
    <?= Html::button('Профиль пользователя',['value' => Url::to(['//user/view','id' => $model->user->id]), 'class' => 'btn btn-sm btn-primary modalButton']);?>
    <?php
        echo Html::button('<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Сообщение',
                        ['class' => 'btn btn-primary btn-sm modalButton','value'=> Url::to(['//message/create','id' => $model->user->id])] );
    ?>
    </div>  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            [
                'attribute' => 'user.fullname',
            ],
            [
                'attribute' => 'groupName',
                'value' => Html::a($model->groupName,  Url::to(['//group/view','id'=>$model->group->id])),
                'format' => 'raw'
            ],
            'education_start_date:date',
            'education_end_date:date',
            'group.currentSemesterNumber'
        ],
    ]) ?>    
    <div class="list-group">
        
            <?php
                echo "<div class='list-group-item list-group-item-success'>Статистика заданий</div>";
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

</div>
