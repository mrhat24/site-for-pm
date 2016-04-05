<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Дисциплины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discipline-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Создать',['value'=> Url::to(['discipline/create']),
        'class' => 'btn btn-success modalButton']);?>     
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
    
</div>

<?php
Modal::begin([
            'header' => '<h2>Управление заданиями</h2>',
            //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
