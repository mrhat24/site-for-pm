<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\jui\AutoComplete;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Студенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::button('Добавить студента',['value'=> Url::to(['create']),
        'class' => 'btn btn-success modalButton']);?> 
    </p>
    <?php Pjax::begin(['enablePushState' => false]); ?>     
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'fullname',
            'groupName',
            //'education_start_date:date',                                        
            //'education_end_date:date',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
 <?php
    
        Modal::begin([
                'header' => '',
                //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
                'id' => 'modal',
                'size' => 'modal-lg',     
                'options' => [
                    'tabindex' => false
                ]
            ]);        
        echo "<div id='modalContent'></div>";
        Modal::end();
        
?>

