<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\TaskType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Управление типами', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?> 
<div class="task-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <div class="btn-group">
        <?php echo Html::beginTag('button',['value'=> Url::to(['task-type/index']),
            'class' => 'btn btn-primary modalButton']);
            echo Html::tag('span','',['class' => 'glyphicon glyphicon-menu-left']);
             echo Html::endTag('button'); ?>  
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        </div>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
