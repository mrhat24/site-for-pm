<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Lesson;
use common\models\GroupHasDiscipline;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$date = new DateTime();
$todayDate =  $date->format("Y-m-d");
$ghd = GroupHasDiscipline::find()->where(['group_id' => $group])->andWhere(['<=','start_date',$todayDate])->andWhere(['>=','end_Date',$todayDate])->all();
if(!$ghd) {  throw new NotFoundHttpException('Страница не найдена.');}
$this->title = 'Расписание группы '.$ghd[0]->group->name;
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['site/information'])];
$this->params['breadcrumbs'][] = ['label' => 'Расписание', 'url' => Url::to(['lesson/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::encode("Общее расписание");?>
    </p>
    
    <?php
    $ghd_id_arr = array();
    foreach ($ghd as $grouphasdisc){
        array_push($ghd_id_arr,$grouphasdisc->id);
    };
    $lessons = Lesson::find()->where(['ghd_id' => $ghd_id_arr])->orderBy('week ASC, day ASC, time ASC')->all();            
    $schedule = array();    
    for($week = 1; $week <= 2; $week++)
    {
        $schedule[$week][] =  Html::beginTag('table',['class' => 'table table-bordered center-align']);   
        $schedule[$week][] =  Html::beginTag('tr');
        $schedule[$week][] =  Html::tag('th','День недели',['class' => 'center-align']);
        $schedule[$week][] =  Html::tag('th','Неделя - '.$week, ['class' => 'center-align', 'colspan'=> '4']);
        for($day = 1; $day <= 6; $day++)
        {   
            $schedule[$week][] =  Html::beginTag('tr');
            $schedule[$week][] =  Html::tag('th',  Lesson::getDayName($day), ['class' => 'center-align lesson-day', 'colspan'=> '5']);            
            $schedule[$week][] =  Html::beginTag('tr');
            $schedule[$week][] =  Html::tag('th',"Предмет", ['class' => 'center-align']);
            $schedule[$week][] =  Html::tag('th','Время', ['class' => 'center-align']);
            $schedule[$week][] =  Html::tag('th','Преподаватель', ['class' => 'center-align']);
            $schedule[$week][] =  Html::tag('th','Аудитория', ['class' => 'center-align']);
            $schedule[$week][] =  Html::tag('th','Тип занятия', ['class' => 'center-align']);
            $schedule[$week][] =  Html::endTag('tr');
            $schedule[$week][] =  Html::beginTag('tr');
            foreach($lessons as $lesson)
            {
                $schedule[$week][] =  Html::beginTag('tr');
                if(($week == $lesson->week)AND($day == $lesson->day))
                {
                   $schedule[$week][] =  Html::tag('td',$lesson->groupHasDiscipline->discipline->name);
                   $schedule[$week][] =  Html::tag('td',$lesson->time);
                   $schedule[$week][] =  Html::tag('td',$lesson->teacher->user->fullname);
                   $schedule[$week][] =  Html::tag('td',$lesson->auditory);
                   $schedule[$week][] =  Html::tag('td',$lesson->lessonType->name);
                }
                $schedule[$week][] =  Html::endTag('tr');
            }          
            $schedule[$week][] =  Html::endTag('tr');
            $schedule[$week][] =  Html::endTag('tr');
        }
        $schedule[$week][] =  Html::endTag('tr');
        $schedule[$week][] =  Html::endTag('table');
    }
    
    ?>

    <?php /* = ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]) */ 
    $tabs = array();
    foreach($schedule as $key => $sch)
    {
        $tabs[] = [
            'label' => 'Неделя - '.$key,
            'content' => implode($sch),            
        ];
    }
    echo Tabs::widget([
        'items' => $tabs,
    ]); 
    ?>

</div>