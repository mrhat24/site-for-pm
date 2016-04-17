<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TeacherHasDiscipline */

$this->title = 'Create Teacher Has Discipline';
$this->params['breadcrumbs'][] = ['label' => 'Teacher Has Disciplines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-has-discipline-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
