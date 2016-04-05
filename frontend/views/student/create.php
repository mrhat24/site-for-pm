<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = 'Добавление студента';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_chief', [
        'model' => $model,
    ]) ?>

</div>
