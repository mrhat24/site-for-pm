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
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap\Modal;
$this->title = 'Управление заданиями';
$this->params['breadcrumbs'][] = ['label' => 'Преподавателю','url' => ['/teacher/cabinet']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-cabinet">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       <?php
     
       ?> 
    </p>   
    
    <p>
        <div class="btn-group">
         <?= Html::a('Создать',Url::to(['task/create']),[
        'class' => 'btn btn-primary']);?>     
        <?= Html::button('Управление типами',['value'=> Url::to(['task-type/index']),
        'class' => 'btn btn-primary modalButton']);?>    
        </div>
    </p>    
        
        <?php
            Pjax::begin(['enablePushState' => false]);
                     
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,                
                'layout'=>"\n{items}\n{pager}\n{summary}",
                'options' => ['class' => 'table table-responsive'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    [
                        'attribute' => 'type_id',
                        'value' => 'taskType.name',
                        'label' => 'Тип',
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\TaskType::find()->all(),'name','name'),
                    ], 
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '<div class="btn-group">{view} {update} {delete}</div>',
                        'buttons' => [
                            'view' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['value'=> $url,
        'class' => 'btn btn-default modalButton']);
                            },
                            'update' => function ($url, $model)
                            {
                                return Html::a('<span class="glyphicon glyphicon glyphicon-pencil"></span>',$url,[
        'class' => 'btn btn-default']);
                            },
                            'delete' => function ($url, $model)
                            {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url,[
        'class' => 'btn btn-default', 'data-method' => 'post', 'data-confirm' => 'Вы уверены что хотите это удалить?']);
                            },
                        ]
                     ],
                  
                ]
                
            ]);
            Pjax::end();
        ?>
  
 <?php
        Modal::begin([

                //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
                'id' => 'modal',
                'size' => 'modal-lg',      
                'clientOptions' => [
                    'modal' => true,
                    'autoOpen' => false,
                ],
            ]);        
        echo "<div id='modalContent' style='overflow:hidden;'></div>";
        Modal::end();
    ?>
</div>
