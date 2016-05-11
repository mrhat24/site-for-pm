<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use frontend\models\TeacherHasDisciplineSearch;
use yii\grid\GridView;
use yii\widgets\Pjax;


$thd = $teacher->teacherHasDiscipline;


$searchModel = new TeacherHasDisciplineSearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$teacher->getTeacherHasDiscipline());
$dataProvider->pagination = ['pageSize' => 10];

?>
<div class="well well-sm">
<?php
Pjax::begin(['enablePushState' => false,'id' => 'discipline']);
echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,       
        'columns' => [
            [
                'attribute' => 'disciplineName',
                'value' => function($model) {
                    return Html::a($model->disciplineName,Url::to(['//group-has-discipline','id' => $model->groupHasDiscipline->id]),['data-pjax'=>0]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'groupName',
                'value' => function($model) {
                    return Html::a($model->groupName,Url::to(['//group/view','id' => $model->groupHasDiscipline->group->id]),['data-pjax'=>0]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'semester',
                'value' => function($model){
                    $isCyrrent = ($model->groupHasDiscipline->group->currentSemesterNumber == $model->semester) ? " - текущий": " ";
                    return Html::encode($model->semester.$isCyrrent);
                }
            ]
            
        ]
    ]);
Pjax::end();
?>
</div>