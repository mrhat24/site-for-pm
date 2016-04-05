<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GivenExercise */

$this->title = 'Create Given Exercise';
$this->params['breadcrumbs'][] = ['label' => 'Given Exercises', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="given-exercise-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
