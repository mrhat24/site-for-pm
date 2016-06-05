<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\widgets\MultipleInput;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data',
        'id'=>'user-form',
        'enableAjaxValidation' => true,   
         
            ]]); ?>

    <?= $form->field($model, 'email')->textInput() ?>
    
    <?= $form->field($model, 'username')->textInput() ?>
    
    <?= $form->field($model, 'first_name')->textInput() ?>
    
    <?= $form->field($model, 'middle_name')->textInput() ?>
    
    <?= $form->field($model, 'last_name')->textInput() ?>    
    
    <?= $form->field($model, 'authAssignments')->widget(MultipleInput::className(),  ['min' => 1,'limit' => 10,'columns' => [
        [
            'name'  => 'item_name',
            'type'  => 'dropDownList',
            //'title' => 'Преподаватель',
            'defaultValue' => 'user',            
            'items' => ArrayHelper::map(\common\models\AuthItem::find()->all(),'name','description')
        ],
    ]])?>
       
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
