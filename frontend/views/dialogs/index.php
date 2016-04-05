<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DialogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Диалоги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dialogs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=  Html::a('Создать диалог', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]) ?>

</div>
