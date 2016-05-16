<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">
    <div class="page-header">
      <h1><?= Html::encode($this->title) ?>
      <?= (Yii::$app->user->can('teacher')) ? Html::button('Добавить новость', ['value' => Url::to(['//news/create']),'class' => 'btn btn-primary modalButton pull-right']) : "" ?>
      </h1>
       
    </div>    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
       
<?php Pjax::begin(); ?>    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view',
        'layout' => "{summary}\n{items}\n{pager}",
    ]) ?>
<?php Pjax::end(); ?></div>

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