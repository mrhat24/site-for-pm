<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = 'Создать задание';
$this->params['breadcrumbs'][] = ['label' => 'Преподавателю','url' => ['site/teacher']];
$this->params['breadcrumbs'][] = ['label' => 'Управление заданиями', 'url' => Url::to(['task/control'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
