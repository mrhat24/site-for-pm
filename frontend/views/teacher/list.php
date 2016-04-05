<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список преподавателей';
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to('site/information')];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="teacher-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?//= Html::a('Create Teacher', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_teacher_list',
    ]); ?>

</div>
