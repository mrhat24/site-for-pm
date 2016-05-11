<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\components\DateHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\WorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Диплом';
$this->params['breadcrumbs'][] = ['label' => 'Кабинет студента', 'url' => Url::to(['//student/cabinet'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-graduate">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
<?php
    Pjax::begin(['enablePushState' => false]);
    if($model != null){
        
        echo Html::beginTag('div',['class' => 'btn-group']);
        if(($model->approve_status == 2)||($model->approve_status == null)){
            echo Html::button('Изменить',['value'=> Url::to(['work/edit-graduate']),
                'class' => 'btn btn-primary modalButton']);        
            echo Html::a('Отправить на утверждение', Url::to(['work/send-graduate']),
                ['class' => 'btn btn-success', 'data-method' => 'post', 'data-confirm' => 'Вы уверены что хотите отправить на утверждение?']);
        }       
        /*Html::button('Отправить на утверждение',['value'=> Url::to(['work/edit-graduate']),
        'class' => 'btn btn-success modalButton']);*/
        if($model->approve_status != 3)
        {
            echo Html::a('Удалить',Url::to(['work/delete-graduate','id' => $model->id]),
                ['class' => 'btn btn-danger', 'data-method' => 'post', 'data-confirm' => 'Вы уверены что хотите удалить данную работу?']);
        }
        /*Html::button('Удалить',['value'=> Url::to(['work/delete-graduate']),
        'class' => 'btn btn-danger modalButton']); */ 
        echo Html::endTag('div');
?>
    <p>
<?php
echo Html::beginTag('ul',['class' => 'list-group']);
    echo Html::beginTag('dl',['class' => 'dl-horizontal list-group-item']);              
        echo Html::tag('dt',"Название работы");
        echo Html::tag('dd',$model->workTitle->name);        
    echo Html::endTag('dl');

    echo Html::beginTag('dl',['class' => 'dl-horizontal list-group-item']);  
        echo Html::tag('dt',"Руководитель");
        echo Html::tag('dd',$model->teacher->user->fullname);                    
    echo Html::endTag('dl');
    echo Html::beginTag('dl',['class' => 'dl-horizontal list-group-item']);  
        echo Html::tag('dt',"Статус");
        echo Html::tag('dd',$model->status);                    
    echo Html::endTag('dl');
    echo Html::beginTag('dl',['class' => 'dl-horizontal list-group-item']);  
        echo Html::tag('dt',"Список названий:");
        echo Html::beginTag('dd');
        echo Html::beginTag('ul',['class' => 'list-group']);
        foreach($model->workHistory as $history){
            $class = ($history->id==$model->name) ? "list-group-item-success" :  " list-group-item-warning";
            echo Html::beginTag('li',['class' => 'list-group-item '.$class]); 
            echo $history->name;
            echo Html::tag('span',Yii::$app->formatter->asDatetime($history->creation_date),['class' => 'badge']);
            echo Html::endTag('li');
        }        
        echo Html::endTag('ul'); 
    echo Html::endTag('dl');
    echo Html::endTag('dd');
echo Html::endTag('dl');          
        echo Html::endTag('ul'); 
        
       ?>
    </p>
    <?php
    }
    else {
?>
    <p>
        <?= Html::button('Начать работу',['value'=> Url::to(['work/begin-graduate']),
        'class' => 'btn btn-primary modalButton']);?> 
    </p>
<?php
    }
    Pjax::end();


?>
  
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


</div>
