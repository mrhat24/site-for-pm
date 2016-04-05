<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View 2*/
/* @var $model common\models\Le2sson */

$this->title = $model->id; 
$this->params['breadcrumbs'][] = ['label' => 'Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ghd_id',
            'lesson_type_id',
            'teacher_id',
            'week',
            'day',
            'time',
            'auditory',
            'date',
        ],
    ]) ?>

</div>
