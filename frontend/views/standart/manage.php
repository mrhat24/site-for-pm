<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\StandartSearchtitle */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Стандарты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="standart-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
         <?= Html::button('Добавить стандарт',['value'=> Url::to(['create']),
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
            'key',  
            'name',
            'start_date',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
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
