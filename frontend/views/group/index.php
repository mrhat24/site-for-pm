<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Группы';
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['site/infromation'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['enablePushState' => false]);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,        
        'filterModel' => $searchModel,
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            [
                'attribute' => 'name',
                'value' => function($model){
                    return Html::a($model->name,Url::to(['group/view','id' => $model->id]));
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'speciality.name',
                'label' => 'Специальность'
            ],
            [               
                'label' => 'Количество студентов',
                'value' => function($model){
                    return count($model->students);
                }
            ],
            [               
                //'attribute' => 'steward.user.fullname',
                'label' => 'Староста',
                'value' => function($model){
                    if(isset($model->steward))
                        return Html::button($model->steward->user->fullname,
                                ['value' => Url::to(['student/view','id' => $model->steward->id]), 'class' => 'btn-link modalButton']);
                },
                'format' => 'raw',
            ],
        ]
        
    ]) ?>
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