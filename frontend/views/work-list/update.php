<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WorkList */

function getWorkType($type = null){
    if($type == 1)
        return 'Редактирование темы дипломной работы';
    elseif($type == 2)
        return 'Редактирование темы курсовой работы';
    else
        return '';
};
$this->title = getWorkType($model->work_type_id).": ".$model->name;
?>
<div class="work-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
