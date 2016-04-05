<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\TaskType */

$this->title = 'Создание нового типа заданий';
$this->params['breadcrumbs'][] = ['label' => 'Task Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-type-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
    <?php echo Html::beginTag('button',['value'=> Url::to(['task-type/index']),
        'class' => 'btn btn-primary modalButton']);
        echo Html::tag('span','',['class' => 'glyphicon glyphicon-menu-left']);
         echo Html::endTag('button');
    ?>    
    </p>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
