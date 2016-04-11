<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SpecialitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Добавить новость',['value'=> Url::to(['create']),
        'class' => 'btn btn-success modalButton']);?> 
    </p>
<?php Pjax::begin(['enablePushState' => false]); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'date:dateTime',   
            'user.fullname',
            //'standart.name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="btn-group">{view}{update}{viue}{delete}</div>',
                'buttons' => [
                    'view' => function ($url, $model){
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['value'=> Url::to(['news/view-manage','id' => $model->id]),
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
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<?php
    
        Modal::begin([                               
                'id' => 'modal',
                'size' => 'modal-lg',    
                'options' => [
                        'tabindex' => false
                    ]
            ]);        
        echo "<div id='modalContent'></div>";
        Modal::end();
        
    ?>