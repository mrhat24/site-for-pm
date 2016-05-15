<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\MdEditorHelp;
use common\markdown\MarkdownEditor;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\GroupHasDiscipline */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
        '$("document").ready(function(){
            $("#edit-ghd-info").on("pjax:end", function() {
            $.pjax.reload({container:"#ghd-info"});  //Reload GridView
            $("#modal").modal("hide");
        });
    });'
);

?>


<div class="group-has-discipline-form">
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'edit-ghd-info']);?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
    
    <?= $form->field($model, 'information')->widget(MarkdownEditor::className(),MdEditorHelp::getMdParams());?>
  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>    
    <?php Pjax::end() ?>
   
</div>
 
