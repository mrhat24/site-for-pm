<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use common\models\Work;
$this->title = 'Дипломы';
$this->params['breadcrumbs'][] = ['label' => 'Преподаватель','url' => Url::to(['site/teacher'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-teacher-graduate">
    <h2><?=$this->title?></h2>
    <p>
        <div class="btn-group">
         <?= Html::button('Список тем',['value'=> Url::to(['work-list/index','type' => Work::TYPE_GRADUATE]),
        'class' => 'btn btn-success modalButton']); ?>             
        </div>
        
    </p>  
<?php
    Pjax::begin(['enablePushState' => false]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'table table-responsive'],
        'columns' => [            
            //[ 'class' => 'yii\grid\CheckboxColumn',],
            //'id',
            [
                'attribute' => 'studentFullname',
                'value' => function($model){
                    return Html::button($model->studentFullname,['value' => Url::to(['//student/view','id' => $model->student->id]),'class' => 'btn btn-link modalButton']);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'groupName',
                'value' => function($model){
                    return Html::a($model->student->group->name,Url::to(['//group/view','id' => $model->student->group->id]),['data-pjax' => 0]);
                },
                'format' => 'raw'
            ],
            'workTitle.name',
            'status',
            [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',['value'=> $url,
        'class' => 'btn btn-sm btn-default modalButton']);
                            },
                            /*'update' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon glyphicon-pencil"></span>',['value'=> $url,
        'class' => 'btn btn-default modalButton']);
                            },*/
                            /*'delete' => function ($url, $model)
                            {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>',$url,[
        'class' => 'btn btn-default', 'data-method' => 'post', 'data-confirm' => 'Вы уверены что хотите это удалить?']);
                            },*/
                        ]
            ],
        ]
    ]);
                            
    Pjax::end();
?>
</div>
<?php
Modal::begin([
            //'header' => '<h2>Управление заданиями</h2>',
            //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
?>