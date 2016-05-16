<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['site/information'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['enablePushState' => false]);?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,        
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',           
            'fullname',
            'email:email', 
            [
                'label' => 'Статус',
                'value' => function($model){
                        return $model->role->description;
                },
            ],
            ['class' => 'common\components\ActionColumn',
            'header'=>'Действия', 
            //'headerOptions' => ['width' => '200'],
            'template' => '{view} {update} {delete}',                              
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
<?php
Modal::begin([                        
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
?>