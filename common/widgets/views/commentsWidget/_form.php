<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->registerJs(
        '$("document").ready(function(){
            $("#new-comment").on("pjax:end", function() {
            $.pjax.reload({container:"#comments-pjax"});  //Reload GridView
            $("html,body").animate({scrollTop: $("#comments-pjax").offset().top}, 1000);
        });
    });'
);
?>

<div class="comments-widget-form">
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'new-comment']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>   

    <?= $form->field($model, 'text',['validateOnBlur' => false]
            )->textarea(['rows' => 6])->label('') ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>
</div>
