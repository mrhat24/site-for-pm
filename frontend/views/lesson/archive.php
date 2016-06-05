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
use common\models\Group;
use common\models\GroupSemesters;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$formatter = Yii::$app->formatter;
$groupModel = \common\models\Group::find()->where(['id' => $group])->one();
$semesterModel = GroupSemesters::find()->where(['group_id' => $group, 'semester_number' => $semester])->one();
//$ghd = GroupHasDiscipline::find()->where(['group_id' => $group])->andWhere(['<=','start_date',$todayDate])->andWhere(['>=','end_Date',$todayDate])->all();
//if(!$ghd) {  throw new NotFoundHttpException('Страница не найдена.');}
$this->title = 'Архив. Расписание группы '.$groupModel->name.' '.$semesterModel->semester_number.' семестр.';
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['site/information'])];
$this->params['breadcrumbs'][] = ['label' => 'Расписание', 'url' => Url::to(['lesson/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">
    
    <h3><?= "Архив расписания группы: ".Html::a($groupModel->name,['//group/view','id' => $groupModel->id])  ?>
        <?= Html::encode($formatter->asDate($semesterModel->begin_date)."-".$formatter->asDate($semesterModel->end_date))?></h3>
    <?php
    /*
    $ghd_id_arr = array();
    foreach ($ghd as $grouphasdisc){
        array_push($ghd_id_arr,$grouphasdisc->id);
    };
    $lessons = Lesson::find()->where(['ghd_id' => $ghd_id_arr])->orderBy('week ASC, day ASC, time ASC')->all(); */
    
    $lessons = Lesson::getLessonsList(['group' => $group,'semester' => $semester]);
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