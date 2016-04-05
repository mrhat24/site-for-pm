<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\WorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Работы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Work', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'work_type_id',
            'name',
            'student_id',
            'teacher_id',
            // 'date',
            // 'approve_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
