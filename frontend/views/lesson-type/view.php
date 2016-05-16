<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\LessonType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lesson Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="btn-group">
        <?php echo Html::beginTag('button',['value'=> Url::to(['//lesson-type/index']),
            'class' => 'btn btn-primary modalButton']);
            echo Html::tag('span','',['class' => 'glyphicon glyphicon-menu-left']);
            echo Html::endTag('button');
        ?> 
        <?= Html::button('Редактировать', ['value' => Url::to(['//lesson-type/update',
            'id' => $model->id]),'class' => 'btn btn-primary modalButton']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
