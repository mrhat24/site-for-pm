<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'email')->textInput() ?>
    
    <?= $form->field($model, 'first_name')->textInput() ?>
    
    <?= $form->field($model, 'middle_name')->textInput() ?>
    
    <?= $form->field($model, 'last_name')->textInput() ?>
    
    <?= $form->field($model, 'imageFile')->fileInput() ?>
    
    <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); 
    $list = array();
    foreach(Yii::$app->params['timezones'] as $key => $tz) 
        $list[$tz] = $key;           
        ?>
    
    <?= $form->field($model, 'timezone')->dropDownList($list) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
