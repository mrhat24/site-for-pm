<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Group Has Disciplines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-has-discipline-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Group Has Discipline', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'discipline_id',
            'group_id',
            'semestr_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
