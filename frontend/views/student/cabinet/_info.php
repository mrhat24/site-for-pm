<?php
use yii\helpers\Html;
use common\models\Lesson;
use yii\bootstrap\Tabs;
use common\widgets\Schedule;
use yii\helpers\Url;


$model = Yii::$app->user->identity->student->group;

//Дисциплины
$this->beginBlock('disciplines');
echo Html::beginTag('ul',['class' => 'list-group']);
foreach($model->currentDisciplines as $ghd){
    $teachers = array();
    foreach ($ghd->teacherHasDiscipline as $thd){
        $teachers[] = $thd->teacher;
    }
    echo Html::beginTag('li',['class' => 'list-group-item']);    
    echo Html::a($ghd->discipline->name,  Url::to(['//group-has-discipline','id' => $ghd->id]));
    echo " Преподаватели:";
    foreach($teachers as $teacher){
        echo Html::button($teacher->user->fullname, ['value' => Url::to(['user/view', 'id' => $teacher->user->id]),'class' => 'btn-link modalButton']);
    }
echo Html::endTag('li');
}
echo Html::endTag('ul');
$this->endBlock('disciplines');


$lessons = Lesson::getLessonsList(['teacher' => Yii::$app->user->identity->student->id]);
$schedule = Tabs::widget([
    'options' => ['class' => 'nav nav-pills nav-justified'],
    'items' => [
        [
        'label' => 'Неделя - 1',
        'content' => Schedule::widget([
            'scenario' => 'group',
            'lessons' => $lessons,
            'week' => 1]),
        ],
        [
        'label' => 'Неделя - 2',
        'content' => Schedule::widget([
            'scenario' => 'group',
            'lessons' => $lessons,
            'week' => 2]),
        ]
    ]
]);

echo Tabs::widget([
    'options' => ['class' => 'nav nav-pills nav-justified'],
    'items' => [
        [
        'label' => 'Дисциплины',
        'content' => $this->blocks['disciplines'],
        ], 
        [
        'label' => 'Расписание',
        'content' => $schedule,
        ],       
    ]
]);