<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ExerciseTest */

$this->title = 'Update Exercise Test: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Exercise Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exercise-test-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
