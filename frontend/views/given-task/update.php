<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\GivenTask */
$this->title = 'Update Given Task: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Given Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="given-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_update_form', [
        'model' => $model,
        'result' => $result,
    ]) ?>

</div>