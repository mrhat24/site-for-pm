<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Netcarver\Textile;
use yii\widgets\Pjax;
$parser = new \Netcarver\Textile\Parser();
/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(['id' => 'pjax-view', 'enablePushState' => false]); ?>

<div class="task-view">
    
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
            'name',
           // 'teacher_id',
            [ 
                'attribute' => 'type_id',
                'value' => $model->taskType->name,
            ],
            [
                'attribute' => 'text',
                'value' => $parser->textileThis($model->text),
                'format' => 'html'
            ],
        ],
    ]) ?>
    

</div>
<?php Pjax::end(); ?>