<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
$parser = new \Netcarver\Textile\Parser();
/* @var $this yii\web\View */
/* @var $model common\models\Exercise */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Exercises', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'pjax-view', 'enablePushState' => false]); ?>
<div class="exercise-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'teacher.user.fullname',
            //'text:ntext',
            [ 
                'attribute' => $model->getAttributeLabel('text'),
                'value' => $parser->textileThis($model->text),
                'format' => 'html',
            ],
           
            //'name',
        ],
    ]) ?>

</div>
<?php Pjax::end(); ?>