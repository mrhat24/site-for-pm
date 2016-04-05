<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Speciality */

$this->title = 'Добавить специальность';
$this->params['breadcrumbs'][] = ['label' => 'Specialities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_chief', [
        'model' => $model,
    ]) ?>

</div>
