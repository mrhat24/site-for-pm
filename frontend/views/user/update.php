<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Изменение профиля: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['site/cabinet']];
$this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['view']];
$this->params['breadcrumbs'][] = 'Редактирование профиля';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
