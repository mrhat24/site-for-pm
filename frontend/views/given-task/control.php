<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\DateHelper;
$this->title = 'Выдача заданий';
$this->params['breadcrumbs'][] = ['label' => 'Преподавателю','url' => ['site/teacher']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-cabinet">
    <h1><?= Html::encode($this->title) ?></h1>    
        <p>
        <?= Html::button('Выдать задание',['value'=> Url::to(['given-task/give']),
        'class' => 'btn btn-primary modalButton']);?>  
        </p>
        <?php
            Pjax::begin(['enablePushState' => false]);
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'rowOptions' => function ($model, $key, $index, $grid)
                {
                      return ['class' => $model->statusIdentity['ident']];
                },
                'layout'=>"\n{items}\n{pager}\n{summary}",
                'options' => ['class' => 'table table-responsive'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'taskName',
                    [
                        'attribute' => 'discipline_id',
                        'value' => 'discipline.name',
                        'label' => 'Дисциплина',   
                    ],
                    'studentFullname',
                    [
                        'attribute' => 'status',
                        'value' => function ($model, $key, $index, $grid)
                        {
                              return $model->statusIdentity['rus'];
                        },
                        'label' => 'Статус', 
                        'filter' => common\models\GivenTask::$statusArray,
                    ],  
                    'complete_date:dateTime',
                    'given_date:dateTime',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '<div class="btn-group">{view}{update}{delete}{pdf}</div>',
                        'buttons' => [
                            'view' => function ($url, $model){
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['value'=> Url::to(['given-task/check','id' => $model->id]),
        'class' => 'btn btn-default modalButton']);
                            },
                            'update' => function ($url, $model){
                                return Html::button('<span class="glyphicon glyphicon glyphicon-pencil"></span>',['value'=> $url,
        'class' => 'btn btn-default modalButton']);
                            },
                            'delete' => function ($url, $model){
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url,[
        'class' => 'btn btn-default', 'data-method' => 'post', 'data-confirm' => 'Вы уверены что хотите это удалить?']);
                            },
                            'pdf' => function ($url, $model){
                                return Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span> pdf',
                                    Url::to(['task/pdf-task', 'id' => $model->id]),
                                    ['class' => 'btn btn-success', 'target' => '_blank','data-pjax'=>0]);
                            },        
                        ]
                     ],
                  
                ]
                
            ]);
            Pjax::end();
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
