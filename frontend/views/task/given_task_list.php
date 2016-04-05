<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\bootstrap\Nav;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Выданные задания';
$this->params['breadcrumbs'][] = ['label' => 'Преподавателю', 'url' => Url::to(['site/teacher'])];
$this->params['breadcrumbs'][] = ['label' => 'Управление заданиями', 'url' => Url::to(['task/control'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
     <h1><?= Html::encode($this->title) ?></h1>
    <?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_given_task_list',
    'layout' => "{summary}\n<table class=\"table table-responsive\">{items}</table>\n{pager}", 
]);
?>
</div>