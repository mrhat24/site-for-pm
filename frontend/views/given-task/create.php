<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GivenTask */

$this->title = 'Выдать задание';
$this->params['breadcrumbs'][] = ['label' => 'Given Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="given-task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
