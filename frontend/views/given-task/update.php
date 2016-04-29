<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\GivenTask */
$this->title = 'Редактирование: ' . ' ' . $model->task->name . ' - ' . $model->student->user->fullname. ' - ' . $model->student->group->name;

?>
<div class="given-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_update_form', [
        'model' => $model,
        'result' => $result,
    ]) ?>

</div>