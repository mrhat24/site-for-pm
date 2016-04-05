<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление типами';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Новый тип', ['value' => Url::to(['task-type/create']),
            'class' => 'btn btn-primary modalButton']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',

            [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '<div class="btn-group"> {update} {delete}</div>',
                        'buttons' => [
                            /*'view' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['value'=> $url,
        'class' => 'btn btn-default modalButton']);
                            }, */
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

</div>
