<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GroupHasDiscipline */

$this->title = 'Редактирование: ' . $model->discipline->name." - ".$model->group->name." - Семестр - ".$model->semester_number;
$this->params['breadcrumbs'][] = ['label' => 'Group Has Disciplines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="group-has-discipline-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
