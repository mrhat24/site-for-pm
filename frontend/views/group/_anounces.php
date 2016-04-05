<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

echo Html::tag('br');
$dataProvider = new ActiveDataProvider([
    'query' => $model->getAnounces(),
    'pagination' => [
        'pageSize' => 10,
    ],
]);
Pjax::begin();
echo Html::button('Добавить объявление',['value'=> Url::to(['group/create-anounce']),
    'class' => 'btn btn-primary modalButton']); 
echo Html::tag('hr');
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_anounces_view',
    'layout' => "{items}\n{summary}\n{pager}",    
]);
Pjax::end();
Modal::begin([
        'header' => '<h2>Добавить объявление</h2>',
        //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
        'id' => 'modal',
        'size' => 'modal-lg',                      
    ]);        
echo "<div id='modalContent'></div>";
Modal::end();


