<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Teacher */

$this->title = 'Редактировать преподавателя: ' . ' ' . $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="teacher-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_chief', [
        'model' => $model,
    ]) ?>

</div>
