<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Exercise */

$this->title = 'Редактирование: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Преподавателю','url' => ['//teacher/cabinet']];
$this->params['breadcrumbs'][] = ['label' => 'Упражнения','url' => ['//exercise/control']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="exercise-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
