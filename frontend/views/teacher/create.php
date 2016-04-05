<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Teacher */

$this->title = 'Добавить преподавателя';
$this->params['breadcrumbs'][] = ['label' => 'Teachers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_chief', [
        'model' => $model,
    ]) ?>

</div>
