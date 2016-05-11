<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Work */

$this->title = 'Редактирование курсовой работы: ' . ' ' . $model->disciplineName. '-'. $model->groupName.'-'.$model->studentFullname;
$this->params['breadcrumbs'][] = ['label' => 'Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="work-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
