<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\components\DateHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\WorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Курсовые работы';
$this->params['breadcrumbs'][] = ['label' => 'Кабинет студента', 'url' => Url::to(['//student/cabinet'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

     <p>
        <?php /* echo Html::button('Начать работу',['value'=> Url::to(['work/begin-graduate']),
        'class' => 'btn btn-primary modalButton']); */?> 
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'table-responsive'],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'workTitle.name',
            'discipline.name',
            [
                'label' => 'Преподаватель',
                'attribute' => 'teacher.user.fullname',
            ],
            [
                'label' => 'Дата назначения',
                'value' => function ($model){
                        return \common\components\DateHelper::getDateByUserTimezone($model->date);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="btn-group">{view}</div>',
                    'buttons' => [
                        'view' => function ($url, $model){
                            return Html::button('<span class="glyphicon glyphicon-pencil"></span>',['value'=> Url::to(['work/edit-term','id' => $model->id]),
                                'class' => 'btn btn-primary modalButton']);
                        },                        
                    ]
                ],
        ],
    ]); ?>
    
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

</div>
