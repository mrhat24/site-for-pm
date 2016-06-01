<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WorkList */

$this->title = 'Create Work List';
$this->params['breadcrumbs'][] = ['label' => 'Work Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
