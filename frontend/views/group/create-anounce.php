<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\markdown\MarkdownEditor;
use yii\widgets\Pjax;
use common\components\MdEditorHelp;


$this->registerJs(MdEditorHelp::getJsMath());
$this->registerJs(
    '$("document").ready(function(){
        $("#anounce-form").on("pjax:end", function() {
            $("#modal").modal("hide");
            $.pjax.reload({container:"#anounces_list"});  //Reload GridView
        });
    });'
);
?>
<?php Pjax::begin(['enablePushState' => false,'id' => 'anounce-form']);?>
<div class="group-form">
    
    <h2><?php echo $model->isNewRecord ? 'Добавить объявление' : 'Изменить объявление'; ?></h2>

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>   
 
    
    <?= $form->field($model, 'text')->widget(MarkdownEditor::className(),MdEditorHelp::getMdParams()); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end();?>