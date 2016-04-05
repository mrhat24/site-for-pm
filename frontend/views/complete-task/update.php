<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CompleteTask */

$this->title = 'Update Complete Task: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Complete Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complete-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
