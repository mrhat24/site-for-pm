<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\GroupAnounces;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use common\models\Lesson;
use common\widgets\Schedule;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = $model->name;
if(isset(Yii::$app->user->identity->student)&&(Yii::$app->user->identity->student->group->id === $model->id))
$this->params['breadcrumbs'][] = ['label' => 'Кабинет студента', 'url' => ['//student/cabinet']];
else
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['//group']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="group-view">
 
    <h1><?= Html::encode($this->title) ?></h1>

<?php
    $this->beginBlock('info');
    $listArray = array();
    $listArray[] = ['name' => $model->getAttributeLabel('speciality_id'),
        'val' => $model->speciality->name];
    if(isset($model->steward))
    $listArray[] = ['name' => $model->getAttributeLabel('steward_student_id'),
        'val' => Html::button($model->steward->user->fullname,['value' => Url::to(['//student/view','id' => $model->steward->id]), 'class' => 'btn-link modalButton'] )];
    $listArray[] = ['name' => 'Количество студентов',
        'val' => count($model->students)];
    $listArray[] = ['name' => 'Текуший семестр',
        'val' => $model->currentSemesterNumber];
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
    echo Html::button($student->user->fullname, ['value' => Url::to(['student/view',
        'id' => $student->id]),'class' => 'list-group-item btn-link modalButton']);        
    }        
    echo Html::endTag('ul');
    $this->endBlock('students');
?>

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
                'content' => $this->render('_disciplines',['model' => $model]),
            ],
            [
                'label' => 'Расписание',
                'content' => $this->render('_schedule',['model' => $model]),
            ],

        ],
        'options' => ['class' => 'nav nav-pills nav-justified'],
        'itemOptions' => ['tag' => 'div','class' => 'well well-sm'],
        'headerOptions' => ['class' => 'my-class'],
        'clientOptions' => ['collapsible' => true],
    ]);      
    ?>
</div>
<?php
    
Modal::begin([        
        //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
        'id' => 'modal',
        'size' => 'modal-lg',                      
    ]);        
echo "<div id='modalContent'></div>";
Modal::end();
?>