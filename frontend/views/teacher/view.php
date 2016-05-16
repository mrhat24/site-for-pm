<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\Teacher */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>
    <?= Html::button('Профиль пользователя',['value' => Url::to(['//user/view','id' => $model->user->id]), 'class' => 'btn btn-sm btn-primary modalButton']);?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.fullname',
            'post:ntext',
            'academic_degree',
        ],
    ]) ?>

</div>
