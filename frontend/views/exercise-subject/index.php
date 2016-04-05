<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление категориями';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercise-subject-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Создать',['value'=> Url::to(['exercise-subject/create']),
        'class' => 'btn btn-primary modalButton']);?>  
    </p>
    <?php Pjax::begin(['id' => 'exercise-subject-pjax' ,'enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'exercise-subject-pjax',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
           // 'teacher_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="btn-group">{update} {delete}</div>',
                'buttons' => [
                    /*'view' => function ($url, $model)
                    {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['value'=> $url,
                        'class' => 'btn btn-default modalButton']);
                    },*/
                    'update' => function ($url, $model)
                    {
                        return Html::button('<span class="glyphicon glyphicon glyphicon-pencil"></span>',['value'=> $url,
                        'class' => 'btn btn-default modalButton']);
                    },
                    'delete' => function ($url, $model)
                    {
                        return Html::button('<span class="glyphicon glyphicon-trash"></span>',['value' => $url,
                        'class' => 'btn btn-default modalButton', 'data-confirm' => 'Вы уверены что хотите это удалить?']);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
