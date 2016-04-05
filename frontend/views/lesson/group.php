<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Lesson;
use common\models\GroupHasDiscipline;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use common\widgets\Schedule;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$date = new DateTime();
$todayDate =  $date->format("Y-m-d");
$model = \common\models\Group::find()->where(['id' => $group])->one();
//$ghd = GroupHasDiscipline::find()->where(['group_id' => $group])->andWhere(['<=','start_date',$todayDate])->andWhere(['>=','end_Date',$todayDate])->all();
//if(!$ghd) {  throw new NotFoundHttpException('Страница не найдена.');}
$this->title = 'Расписание группы '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['site/information'])];
$this->params['breadcrumbs'][] = ['label' => 'Расписание', 'url' => Url::to(['lesson/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    /*
    $ghd_id_arr = array();
    foreach ($ghd as $grouphasdisc){
        array_push($ghd_id_arr,$grouphasdisc->id);
    };
    $lessons = Lesson::find()->where(['ghd_id' => $ghd_id_arr])->orderBy('week ASC, day ASC, time ASC')->all(); */
    
    $lessons = Lesson::getLessonsList(['group' => $group]);   
    echo Tabs::widget([
        'items' => [
            [
            'label' => 'Неделя - 1',
            'content' => Schedule::widget(['scenario' => 'group',
                'lessons' => $lessons,
                'week' => 1]),            
            ],
            [
            'label' => 'Неделя - 2',
            'content' => Schedule::widget(['scenario' => 'group',
                'lessons' => $lessons,
                'week' => 2]),            
            ]
        ]
    ]); 
    ?>

</div>


