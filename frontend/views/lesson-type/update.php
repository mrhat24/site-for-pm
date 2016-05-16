<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\LessonType */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lesson Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lesson-type-update">

    <h1><?= Html::encode($this->title) ?></h1>
     <?php echo Html::beginTag('button',['value'=> Url::to(['//lesson-type/index']),
        'class' => 'btn btn-primary modalButton']);
        echo Html::tag('span','',['class' => 'glyphicon glyphicon-menu-left']);
        echo Html::endTag('button');
    ?>  
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
