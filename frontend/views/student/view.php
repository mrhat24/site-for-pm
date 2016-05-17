<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>
    <div class="btn-group">
    <?= Html::button('Профиль пользователя',['value' => Url::to(['//user/view','id' => $model->user->id]), 'class' => 'btn btn-sm btn-primary modalButton']);?>
    <?php
        echo Html::button('<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Сообщение',
                        ['class' => 'btn btn-primary btn-sm modalButton','value'=> Url::to(['//message/create','id' => $model->user->id])] );
    ?>
    </div>  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'user.fullname',
            'group.name',
            'education_start_date:date',
            'education_end_date:date',
        ],
    ]) ?>

</div>
