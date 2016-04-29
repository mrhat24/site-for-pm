<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GroupHasDiscipline */

$this->title = 'Назначить дисциплину группе';
$this->params['breadcrumbs'][] = ['label' => 'Предметы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-has-discipline-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tModel' => $tModel,
    ]) ?>

</div>
