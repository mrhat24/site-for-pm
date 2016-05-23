<?php

use frontend\models\GroupHasDisciplineSearch;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$ghdSearchModel = new GroupHasDisciplineSearch();
$query = $model->getDisciplines();
$ghdDataProvider = $ghdSearchModel->search(Yii::$app->request->queryParams,$query);

Pjax::begin(['enablePushState' => false,'id' => 'discipline']);
    echo GridView::widget([
        'dataProvider' => $ghdDataProvider,
        'filterModel' => $ghdSearchModel,       
        'columns' => [
            [
                'attribute' => 'disciplineName',
                'value' => function($model) {
                    return Html::a($model->disciplineName,Url::to(['//group-has-discipline','id' => $model->id]));
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'semester_number',
                'value' => function($model){
                    $isCyrrent = ($model->group->currentSemesterNumber == $model->semester_number) ? " - текущий": " ";
                    return Html::encode($model->semester_number.$isCyrrent);
                },
                'filter' => Html::activeDropDownList($ghdSearchModel,'semester_number', \yii\helpers\ArrayHelper::map($model->semesters,'semester_number','semester_number'),['class'=>'form-control','prompt' => 'Выберите семестр']),                                        
            ],
            [
                'label' => 'Преподаватели',
                'value' => function($model) {
                    $result = "";
                    foreach ($model->teacherHasDiscipline as $thd){
                        $result = $result.Html::button($thd->teacher->user->fullname,['value' => Url::to(['//teacher/view','id' => $thd->teacher->id]), 'class' => 'btn-link modalButton']);
                    }
                    return $result;
                },
                'format' => 'raw',
            ],
            
            
        ]
    ]);
Pjax::end();