<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\GroupAnounces;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\widgets\Schedule;
use common\models\GroupHasDiscipline;
use common\models\Lesson;
/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Студенту', 'url' => ['site/student']];
$this->params['breadcrumbs'][] = $this->title;
$group = $model->id;

$date = new DateTime();
$todayDate =  $date->format("Y-m-d");
?>
<div class="group-view">
 
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        $this->beginBlock('info');
        $listArray = array();
        $listArray[] = ['name' => $model->getAttributeLabel('speciality_id'),
            'val' => $model->speciality->name];
        $listArray[] = ['name' => $model->getAttributeLabel('steward_student_id'),
            'val' => Html::a($model->steward->user->fullname,
                Url::to(['user/view','id' => $model->steward->user->id]))];
        $listArray[] = ['name' => 'Студентов',
            'val' => count($model->students)];
        echo Html::tag('br');
        echo Html::beginTag('ul',['class' => 'list-group']);
        echo Html::beginTag('dl',['class' => 'dl-horizontal']);
        
        foreach ($listArray as $li){
            echo Html::beginTag('li',['class' => 'list-group-item']);        
            echo Html::tag('dt',$li['name']);
            echo Html::tag('dd',$li['val']);
            echo Html::endTag('li');
        }
        
        echo Html::endTag('dl');
        echo Html::endTag('ul');
        $this->endBlock('info');          
    ?>
    
    <?php
        $this->beginBlock('students');
        echo Html::tag('br');        
        echo Html::beginTag('ul',['class' => 'list-group']);
        foreach($model->studentsOrderedByLastName as $student){
        echo Html::a($student->user->fullname,  Url::to(['user/view',
            'id' => $student->user->id]),['class' => 'list-group-item']);        
        }        
        echo Html::endTag('ul');
        $this->endBlock('students');
    ?>
    
    <?php
        $this->beginBlock('disciplines');
        echo Html::tag('br');
        echo Html::beginTag('ul',['class' => 'list-group']);
        foreach($model->disciplineList as $discipline){
        echo Html::tag('li',$discipline->name,['class' => 'list-group-item']);
        }
        //echo Html::tag('li',$model->speciality->name);
        echo Html::endTag('ul');
        $this->endBlock('disciplines');
    ?>
    
    <div class="panel panel-default">
        <div class="panel-body">
     <?php
     echo Tabs::widget([
    'items' => [
        [
            'label' => 'Информация',
            'content' => $this->blocks['info'],
        ],
        [
            'label' => 'Объявления',
            'content' => $this->render('_anounces',['model' => $model]),
        ],
        [
            'label' => 'Список студентов',
            'content' => $this->blocks['students'],
        ],
        [
            'label' => 'Список дисциплин',
            'content' => $this->blocks['disciplines'],
        ],
        [
            'label' => 'Расписание',
            'content' =>  $this->render('_schedule',['model' => $model]),
        ],        
    ],
    'options' => ['tag' => 'div', 'class' => 'nav nav-tabs nav-justified'],
    'itemOptions' => ['tag' => 'div'],
    'headerOptions' => ['class' => 'my-class'],
    'clientOptions' => ['collapsible' => true],
]);      
    ?>
        </div>
    </div>
</div>
