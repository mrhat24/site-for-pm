<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use frontend\models\WorkSearch;
use common\models\Work;

$searchModel = new WorkSearch(([ 'work_type_id' => Work::TYPE_GRADUATE, 'approve_status' => Work::STATUS_SENDED]));
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


?>
<div class="work-chief-graduate">    
<?php
    Pjax::begin(['enablePushState' => false,'id' => 'chief-gradiate-container']);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'table table-responsive'],
        'columns' => [            
            //[ 'class' => 'yii\grid\CheckboxColumn',],
            //'id',
            'studentFullname',
            'groupName',
            'workTitle.name',
            'status',
            [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{approve}{nopprove}',
                        'buttons' => [
                            'view' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon-eye-open"></span> Смотреть',['value'=> Url::to(['//work/view','id' => $model->id]),
        'class' => 'btn btn-default modalButton']);
                            },
                            'approve' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon-ok"></span> Утвердить',
                                        ['value' => Url::to(['//chief/approve-graduate', 
                                    'id' => $model->id,'status' => Work::STATUS_APPROVED]),'class' => 'btn btn-default postPjaxButton',
                                            'container' => '#chief-gradiate-container','data-pjax' => 1]);
                            },
                            'nopprove' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon-remove"></span> Отклонить',
                                        ['value' => Url::to(['//chief/approve-graduate','id' => $model->id,'status' => Work::STATUS_NOT_APPROVED]),
                                            'container' => '#chief-gradiate-container','data-pjax' => 1,
                                            'class' => 'btn btn-default postPjaxButton']);
                            },
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