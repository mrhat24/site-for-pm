<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Exercise */

$this->title = 'Update Exercise: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Exercises', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exercise-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
