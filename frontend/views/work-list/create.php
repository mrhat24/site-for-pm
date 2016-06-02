<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WorkList */

function getWorkType($type = null){
    if($type == 1)
        return 'Создать тему дипломов';
    elseif($type == 2)
        return 'Создать тему курсовых';
    else
        return '';
};
$this->title = getWorkType($model->work_type_id);

$this->params['breadcrumbs'][] = ['label' => 'Work Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
