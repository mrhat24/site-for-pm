<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->registerJs(
    '$("document").ready(function(){
        $("#new_note").on("pjax:end", function() {
            $.pjax.reload({container:"#notes"});  //Reload GridView
        });
    });'
);


$dataProvider = new ActiveDataProvider([
    'query' => $model->getAnounces(),
    'pagination' => [
        'pageSize' => 10,
    ],
]);

echo Html::button('Добавить объявление',['value'=> Url::to(['//group/create-anounce', 'id' => $model->id]),
    'class' => 'btn btn-sm btn-primary modalButton btn-block']); 
echo '<hr/>';
Pjax::begin(['enablePushState' => false,]);
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_anounces_view',
    'layout' => "{items}\n{summary}\n{pager}",    
]);
Pjax::end();

