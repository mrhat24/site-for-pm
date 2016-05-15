<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use common\widgets\CommentsWidget;
/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">
    <div class="page-header">
      <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
          <?=Html::encode($model->text)?>
        </div>    
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-11"><h6> Дата добавления: <?= Yii::$app->formatter->asDatetime($model->date)?> | 
                    Автор: <?=Html::button($model->user->fullname,  ['value' => Url::to(['user/view','id' => $model->user->id]), 'class' => 'btn-link modalButton'])?><h6></div>    
                </div>
            </li>
            <li class="list-group-item">
                <?php  
                //Pjax::begin(['enablePushState' => false]);
                echo CommentsWidget::widget(['class_name' => get_class($model), 'item_id' => $model->id]); 
                //Pjax::end();
                ?>
            </li>
        </ul>
    </div>
</div>
<?php
Modal::begin([
    'header' => '',
    //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
    'id' => 'modal',
    'size' => 'modal-lg',                      
]);        
echo "<div id='modalContent'></div>";
Modal::end();
?>