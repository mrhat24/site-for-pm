<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\jui\AutoComplete;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Преподаватели';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-index">    
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Добавить преподавателя',['value'=> Url::to(['create']),
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
            'fullname',            
            'post:ntext',
            'academic_degree',
            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
    
    <?php Pjax::end(); ?>

</div>
<?php
    
        Modal::begin([                               
                'id' => 'modal',
                'size' => 'modal-lg',                
            ]);        
        echo "<div id='modalContent'></div>";
        Modal::end();
        
?>