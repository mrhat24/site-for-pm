<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;


$dataProvider = new ActiveDataProvider([
    'query' => $model->getAnounces(),
    'pagination' => [
        'pageSize' => 10,
    ],
]);


$add_button = Html::button('Добавить объявление',['value'=> Url::to(['//group/create-anounce', 'id' => $model->id]),
    'class' => 'btn btn-sm btn-primary modalButton']); 
if(Yii::$app->user->can('teacher')||Yii::$app->user->can('chief')||Yii::$app->user-can('manager')||isset(Yii::$app->user->identity->student->isSteward))
echo $add_button;
echo "<hr/>";
Pjax::begin(['enablePushState' => false,'id' => 'anounces_list']);
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_anounces_view',
    'layout' => "{items}\n{summary}\n{pager}",    
]);
Pjax::end();

