<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ExerciseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Упражнения';
$this->params['breadcrumbs'][] = ['label' => 'Преподавателю','url' => ['/teacher/cabinet']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercise-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-group">
        <?= Html::a('Создать',Url::to(['exercise/create']),[
        'class' => 'btn btn-primary']);?>     
        <?= Html::button('Управление категориями',['value'=> Url::to(['exercise-subject/index']),
        'class' => 'btn btn-primary modalButton']);?>     
        </div>
    </p>
    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"\n{items}\n{pager}\n{summary}",
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'teacher_id',
            //'text:ntext',           
            'name',
            [
                'attribute' => 'subject_id',
                'value' => 'subject.name',
                'filter' => yii\helpers\ArrayHelper::map(\common\models\ExerciseSubject::find()
                        ->where(['teacher_id' => Yii::$app->user->identity->teacher->id])                        
                        ->distinct()
                        ->all()
                        ,'name','name'),
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
                        'class' => 'btn btn-default', 'data-pjax' => 0 ]);
                    },
                    'delete' => function ($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url,[
                        'class' => 'btn btn-default', 'data-method' => 'post', 'data-confirm' => 'Вы уверены что хотите это удалить?']);
                    },
                ]
            ],
        ],
        
    ]); ?>
    <?php Pjax::end(); ?>
    
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
