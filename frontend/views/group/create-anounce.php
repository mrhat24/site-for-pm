<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>
<?php Pjax::begin(['enablePushState' => false,'id' => 'anounce-form']);?>
<div class="group-form">
    
    <h2>Добавить объявление</h2>

    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>   
 
    
    <?= $form->field($model, 'text')->widget(Markdowneditor::className()); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php Pjax::end();?>