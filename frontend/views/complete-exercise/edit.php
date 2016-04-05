<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CompleteExercise */

/* $this->title = 'Create Complete Exercise';
$this->params['breadcrumbs'][] = ['label' => 'Complete Exercises', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; */
?>
<div class="complete-exercise-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
