<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\LessonType */

$this->title = 'Создание типа лекций';
$this->params['breadcrumbs'][] = ['label' => 'Lesson Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-type-create">

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
