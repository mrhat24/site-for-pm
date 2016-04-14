<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Message */

$this->title = 'Сообщение пользователю: '.$model->recipient->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_fast_message', [
        'model' => $model,
    ]) ?>

</div>
