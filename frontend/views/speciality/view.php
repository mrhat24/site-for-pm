<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Speciality */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Specialities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php /* echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */ ?>
        <?php /*echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'code',
            'start_date',
            [
                'label' => 'Стандарт',
                'value' => $model->standart->name,
            ],
            [
                'label' => 'Код стандарта',
                'value' => $model->standart->key,
            ],
        ],
    ]) ?>

</div>
