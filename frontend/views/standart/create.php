<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Standart */

$this->title = 'Добавление стандарта';
$this->params['breadcrumbs'][] = ['label' => 'Standarts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="standart-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_chief', [
        'model' => $model,
    ]) ?>

</div>
