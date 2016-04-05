<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\ExerciseSubject */

$this->title = 'Создание категории';
$this->params['breadcrumbs'][] = ['label' => 'Exercise Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercise-subject-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    <?php echo Html::beginTag('button',['value'=> Url::to(['exercise-subject/index']),
        'class' => 'btn btn-primary modalButton']);
        echo Html::tag('span','',['class' => 'glyphicon glyphicon-menu-left']);
         echo Html::endTag('button');
    ?>    
    </p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
