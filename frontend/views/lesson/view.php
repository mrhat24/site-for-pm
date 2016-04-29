<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View 2*/
/* @var $model common\models\Le2sson */

$this->title = 'Редактирование: ' . $model->groupHasDiscipline->group->name." - ". $model->groupHasDiscipline->discipline->name;
$this->params['breadcrumbs'][] = ['label' => 'Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Редактировать', ['value' => Url::to(['update', 'id' => $model->id]),'class' => 'btn btn-primary modalButton']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите это удалить?',
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
            'teacherHasDiscipline.teacher.user.fullname',
            'week',
            'day',
            'time',
            'auditory',
            'date',
        ],
    ]) ?>

</div>
