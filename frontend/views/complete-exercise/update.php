<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CompleteExercise */

$this->title = 'Update Complete Exercise: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Complete Exercises', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complete-exercise-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
