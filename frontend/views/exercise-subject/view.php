<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ExerciseSubject */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Exercise Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercise-subject-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <div class="btn-group">
        <?php 
        echo Html::beginTag('button',['value'=> Url::to(['exercise-subject/index']),
        'class' => 'btn btn-primary modalButton']);              
        echo Html::tag('span','',['class' => 'glyphicon glyphicon-menu-left']);
        echo Html::endTag('button'); ?>    
        <?= Html::button('Изменить',['value'=> Url::to(['exercise-subject/update','id' => $model->id]),
        'class' => 'btn btn-primary modalButton']); ?>
        <?= Html::button('Удалить', ['value' => Url::to(['exercise-subject/delete','id' => $model->id]),
            'class' => 'btn btn-danger modalButton',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                //'method' => 'post',
            ],
        ]) ?>
        </div>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            //'teacher_id',
        ],
    ]) ?>

</div>
