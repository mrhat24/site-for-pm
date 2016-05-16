<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\ExerciseSubject */

$this->title = 'Изменение категории: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Exercise Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exercise-subject-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        
    <?php 
    echo Html::beginTag('button',['value'=> Url::to(['exercise-subject/index']),
        'class' => 'btn btn-primary modalButton']);
    echo Html::tag('span','',['class' => 'glyphicon glyphicon-menu-left']);
    echo Html::endTag('button'); ?>    
        
    </p>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
