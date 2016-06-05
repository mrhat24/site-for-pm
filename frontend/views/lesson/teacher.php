<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Lesson;
use common\models\GroupHasDiscipline;
use yii\helpers\Url;
use common\models\Teacher;
use yii\web\NotFoundHttpException;
use yii\bootstrap\Tabs;
use common\widgets\Schedule;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$date = new DateTime();
$todayDate =  $date->format("Y-m-d");
$Teacher = Teacher::findOne($teacher);
if(!$Teacher) {  throw new NotFoundHttpException('Страница не найдена.');}
//if(!$ghd) { echo Html::tag('h3','Расписания данной группы не существует или оно еще не заполнено!');    return;}
$this->title = 'Расписание преподавателя '.$Teacher->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['site/information'])];
$this->params['breadcrumbs'][] = ['label' => 'Расписание', 'url' => Url::to(['lesson/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">

    <h3><?= "Расписание преподавателя: ".Html::button($Teacher->user->fullname,
            ['class' => 'btn btn-lg btn-link modalButton','value' => Url::to(['//teacher/view','id' => $Teacher->id])]); ?></h3>
    
    
    <?php
    
    //$lessons = Lesson::find()->where(['teacher_id' => $teacher])->orderBy('week ASC, day ASC, time ASC')->all();            
    $lessons = Lesson::getLessonsList(['teacher' => $teacher]);
    
    echo Tabs::widget([
        'options' => ['class' => 'nav nav-pills nav-justified'],
        'items' => [
            [
            'label' => 'Неделя - 1',
            'content' => Schedule::widget([
                'scenario' => Schedule::SCENARIO_TEACHER,
                'lessons' => $lessons,
                'week' => 1]),            
            ],
            [
            'label' => 'Неделя - 2',
            'content' => Schedule::widget([
                'scenario' => Schedule::SCENARIO_GROUP,
                'lessons' => $lessons,
                'week' => 2]),            
            ]
        ]
    ]); 
    ?>

</div>
<?php
Modal::begin([
    'header' => '',
    //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
    'id' => 'modal',
    'size' => 'modal-lg',                      
]);        
echo "<div id='modalContent'></div>";
Modal::end();
?>