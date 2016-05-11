<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ExerciseTest */

$this->title = 'Create Exercise Test';
$this->params['breadcrumbs'][] = ['label' => 'Exercise Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercise-test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
