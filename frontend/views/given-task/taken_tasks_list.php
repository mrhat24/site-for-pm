<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задания';
$this->params['breadcrumbs'][] = ['label' => 'Кабинет студента', 'url' => Url::to(['//student/cabinet'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
     <h1><?= Html::encode($this->title) ?></h1>
     
     <?php
            Pjax::begin(['enablePushState' => false]);
                     
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
               // 'layout'=>"\n{items}\n{pager}\n{summary}",
                'rowOptions' => function ($model, $key, $index, $grid)
                {
                      return ['class' => $model->statusIdentity['ident']];
                },
                'options' => ['class' => 'table table-responsive'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],                    
                    [
                        'attribute' => 'task_id',
                        'value' => 'task.name',
                        'label' => 'Задание',
                        //'filter' => \yii\helpers\ArrayHelper::map(\common\models\TaskType::find()->all(),'name','name'),
                    ],                     
                    [
                        'attribute' => 'discipline_id',
                        'value' => 'discipline.name',
                        'label' => 'Дисциплина',
                        //'filter' => \yii\helpers\ArrayHelper::map(\common\models\TaskType::find()->all(),'name','name'),
                    ],
                    'teacherFullname',
                    [
                        'attribute' => 'status',
                        'value' => function ($model, $key, $index, $grid)
                        {
                              return $model->statusIdentity['rus'];
                        },
                        'label' => 'Статус', 
                        'filter' => common\models\GivenTask::$statusArray,
                    ],  
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '<div class="btn-group">{update} {pdf} </div>',
                        'buttons' => [
                            /*
                            'view' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['value'=> $url,
        'class' => 'btn btn-default modalButton']);
                            },*/
                            'update' => function ($url, $model)
                            {
                                return Html::a('Решать <span class="glyphicon glyphicon glyphicon-pencil"></span>',Url::to(['given-task/taken-view',
                                    'id' => $model->id]),
                                    ['class' => 'btn btn-primary']); 
                            },
                            'pdf' => function ($url, $model)
                            {
                                return Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Печать',                                    
                                    Url::to(['task/pdf-task', 'id' => $model->id]) ,[ 'class' => 'btn btn-success', 'target'=>'_blank', 'data-pjax' => 0 ]); 
                            },
                            /*
                            'delete' => function ($url, $model)
                            {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url,[
        'class' => 'btn btn-default', 'data-method' => 'post', 'data-confirm' => 'Вы уверены что хотите это удалить?']);
                            },*/
                        ]
                     ],
                  
                ]
                
            ]);
            Pjax::end();
        ?>
     
    <?php
    /*
echo ListView::widget([ 
    'dataProvider' => $dataProvider, 
    'itemView' => '_taken_tasks_list',  
    'layout' => "{summary}\n<table class=\"table table-responsive\">{items}</table>\n{pager}",  
]); */
?>
</div>
<?php
Modal::begin([
            //'header' => '<h2>Управление заданиями</h2>',
            //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
?>