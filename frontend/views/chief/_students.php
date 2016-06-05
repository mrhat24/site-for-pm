<?php
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use frontend\models\StudentSearch;
use yii\widgets\Pjax;

$searchModel = new StudentSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

$pjax = Pjax::begin(['enablePushState' => false]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        
        [
            'attribute' => 'fullname',
            'value' => function($model){
                return Html::button($model->fullname,['value' => Url::to(['//student/view','id' => $model->id]),'class' => 'text-left btn-link modalButton']);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'groupName',
            'value' => function($model){
                return Html::a($model->groupName,Url::to(['//group/view','id' => $model->group->id]),['class' => 'btn-link', 'data-pjax' => 0]);
            },
            'format' => 'raw'
        ],
        'srb',                
    ]
]);
Pjax::end();
?>