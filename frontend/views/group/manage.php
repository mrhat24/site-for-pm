<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use common\models\Speciality;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление группами';
//$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => Url::to(['site/cabinet'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">
    
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::button('Создать группу',['value'=> Url::to(['group/create']),
        'class' => 'btn btn-success modalButton']);?>  
    </p>
    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"\n{items}\n{pager}\n{summary}",
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],                      
            'name',
            [
                'attribute' => 'specialityName',
                'filter' => ArrayHelper::map(Speciality::find()->all(),'name','name'),
            ],
            [
                'class' => 'common\components\ActionColumn',
                'template' => '{preview} {update} {delete}',
                'buttons' => [
                    'preview' => function ($url, $model)
                    {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['value'=> $url,
                        'class' => 'btn btn-default modalButton','title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),]);
                    },                   
                ]
            ],
        ],
        
    ]); ?>
    <?php Pjax::end(); ?>
   
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

</div>
