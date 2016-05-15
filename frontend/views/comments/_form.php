<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Comments */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
        '$("document").ready(function(){
            $("#comment-update").on("pjax:end", function() {
            $.pjax.reload({container:"#comments-pjax"});  //Reload GridView
            $("#modal").modal("hide");
        });
    });'
);
?>

<div class="comments-form">

    <?php Pjax::begin(['id' => 'comment-update','enablePushState' => false]); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6])->label('') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>
</div>
