<?php
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use frontend\models\TeacherSearch;
use yii\widgets\Pjax;

$searchModel = new TeacherSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

$pjax = Pjax::begin(['enablePushState' => false]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'fullname',
            'value' => function ($model)
                {
                     return Html::button($model->fullname,['value' => Url::to(['//teacher/view','id' => $model->id]), 'class' => 'btn-link modalButton']);
                },   
            'format' => 'raw'
         ],
        
        [
            'label' => 'Дисциплины',
            'value' => function($model){
                $buttons = '';
                foreach($model->teacherHasDiscipline as $thd){
                    $buttons = $buttons.Html::a($thd->groupHasDiscipline->discipline->name." - ".
                            $thd->groupHasDiscipline->group->name,
                            Url::to(['//group-has-discipline','id' => $thd->groupHasDiscipline->id]),['class' => 'btn-link','data-pjax' => 0]);
                }
                return $buttons;
            },
            'format' => 'raw'
        ],                  
    ]
]);
Pjax::end();
?>