<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Message */

$this->title = 'Сообщение пользователю: '.Html::button($model->recipient->fullname,
        ['value' => Url::to(['//user/view', 'id' => $model->recipient->id]),'class' => 'btn btn-link modalButton']);
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <h3><?= $this->title ?></h3>

    <?= $this->render('_fast_message', [
        'model' => $model,
    ]) ?>

</div>
