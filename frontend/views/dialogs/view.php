<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Dialogs */
$this->registerJs('
    $("#refresh").on("click",function(){
    $.pjax.reload({container:"#messages"});
}); 
        ');
$this->title = 'Диалог с: '.$user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Диалоги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dialogs-view">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>
    <?= Html::img('@web/images/reload.png',['id' => 'refresh']) ?>
    
    <?php Pjax::begin(['id' => 'messages']); ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_message',
        'layout' => '{summary}{items}{pager}',       
        'options' => ['class' => 'message-list'],
    ]) ?>
    
    <?php Pjax::end(); ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
