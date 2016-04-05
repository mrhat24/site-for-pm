<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$this->registerJs(  
        '$("#new_message").on("pjax:end", function() {
            $.pjax.reload({container:"#messages"});  //Reload GridView
            console.log("ok");
        });
    '
); 
?>

<div class="message-form">

    <?php Pjax::begin(['id' => 'new_message']); ?>    
    
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

    <?//= $form->field($model, 'from_id')->textInput() ?>

    <?//= $form->field($model, 'to_id')->textInput() ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6])->label(""); ?>

    <?//= $form->field($model, 'active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <?php Pjax::end(); ?>
</div>