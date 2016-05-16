<?php
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use frontend\models\GroupSearch;
use yii\widgets\Pjax;

$searchModel = new GroupSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

$pjax = Pjax::begin(['enablePushState' => false]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'name',
            'value' => function($model){
                return Html::a($model->name, Url::to(['//group/view','id' => $model->id]), ['data-pjax' => 0]);
            },
             'format' => 'raw' 
        ],
        [                               
                'label' => 'Староста',
                'value' => function($model){
                    if(isset($model->steward))
                        return Html::button($model->steward->user->fullname,
                                ['value' => Url::to(['student/view','id' => $model->steward->id]), 'class' => 'btn-link modalButton']);
                },
                'format' => 'raw',
            ],
        [
            'label' => 'Количество студентов',
            'value' => function($model){
                return $model->getStudents()->count();
            },
            'format' => 'raw' 
        ],                   
    ]
]);
Pjax::end();
?>