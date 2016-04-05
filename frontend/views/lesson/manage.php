<?php

use yii\grid\GridView;
//use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Lesson;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LessonSearch */ 
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">
   <h1><?= Html::encode($this->title) ?></h1>
   <?php // echo $this->render('_search', ['model' => $searchModel]); ?> 
   <p>
       <?= Html::button('Добавить занятие',['value'=> Url::to(['create']),
        'class' => 'btn btn-success modalButton']);?>     
   </p>
   <?php   Pjax::begin(['enablePushState' => false]) ?>
   <?= GridView::widget([
       'dataProvider' => $dataProvider,
       'filterModel' => $searchModel,
       'options' => ['class' => 'table-responsive'],
       'columns' => [
           ['class' => 'yii\grid\SerialColumn'],
           //'id',
           'groupName',
           'disciplineName',
           [
               'attribute' => 'lessonTypeName',
               'filter' => ArrayHelper::map(\common\models\LessonType::find()->all(),'name','name'),
           ],
           'teacherFullname',
           [
               'attribute' => 'week',
               'filter' => [1 => 1, 2 => 2],
           ],
            [
                'attribute' => 'day',
                'value' => function ($model){                    
                    return $model->dayRealName;
                },
                'filter' => Lesson::getDaysList(),
            ],
            [
              'attribute' => 'time',
              'filter' => ArrayHelper::map(Lesson::find()->select('time')->distinct()->all(),'time','time'),
            ],            
            'auditory',           
           // 'date',
           ['class' => 'common\components\ActionColumn'],
       ],
   ]); ?>
   <?php Pjax::end() ?>
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
