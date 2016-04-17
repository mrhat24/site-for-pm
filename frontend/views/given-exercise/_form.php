<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use ijackua\lepture\Markdowneditor;
/* @var $this yii\web\View */
/* @var $model common\models\CompleteExercise */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complete-exercise-form">

     <?php   
    /*
            echo $parser->textileThis($exercise->text);
            echo Html::beginForm(['task/taken'],'post',['data-pjax' => true, 'class' => 'form-horizontal']);
            echo Html::textarea('textarea','',['id' => 'markItUp'.$key, 'class' => 'form-control vresize', 'rows' => 20]);
            $this->registerJs(" $('#markItUp{$key}').markItUp(myTextileSettings);  ");  
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'value' => 'true', 'name' => 'submit']);           
            echo Html::hiddenInput('send', 'true'); 
            echo Html::endForm();            
        echo Html::button('Решать',['value'=> Url::to(['complete-exercise/edit','id' => $exercise->id]),'class' => 'btn btn-success modalButton']);
        */
     $this->registerJs('$("#form-exersice").on("pjax:end", function(){
                 $("#modal").modal("hide")});');
    ?>
    
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'form-exersice']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
    <?= Html::tag('p',$model->exercise->text,['class' => 'alert alert-info']); ?> 
    <?= $form->field($model, 'solution')->widget(Markdowneditor::className()) ?>    
    

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php  Pjax::end(); ?>

</div>
