<?php
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */?>
<div class="container-fluid">
<?php
$workListArr = ArrayHelper::map($workList, 'id', 'name', 'teacher.user.fullname');
$teachersArr = ArrayHelper::map($teachers, 'id', 'user.fullname');
$disabledWorks = array();
foreach($workList as $work)
{
    if($work->isReserved){
        $disabledWorks[$work->id] = ['disabled' => true];
    }
}

echo Html::tag('h2','Начать работу');

Pjax::begin(['enablePushState' => false, 'id' => 'begin-graduate']);

echo Html::tag('h4','Выберите интересующую вас тему из списка уже существующих, либо предложите свою.');


$form = ActiveForm::begin([
    'id' => 'begin-graduate-form',
    'options' => ['class' => 'form-horizontal', 'data-pjax' => true],
]) ?>

<div class="form-group">
    <?=Html::label('Список тем'); ?>
    <?=Html::listBox('workList', null, $workListArr,['class' => 'form-control', 'options' => $disabledWorks ]);?>
</div>
<div class="form-group">
    <?=Html::label('Новая тема'); ?>
    <div class="input-group ">    
        <span class="input-group-addon">
            <?=Html::checkbox('newWorkCheckbox')?>
        </span>    
        <span class="input-group-addon" id="basic-addon1">
            Название
        </span>
        <?=Html::textInput('newWorkName',null ,['class' => 'form-control']);?>
        <span class="input-group-addon" id="basic-addon1">
            Руководитель
        </span>
        <?=Html::dropDownList('newWorkTeacher', null, $teachersArr, ['class' => 'form-control']);?>
    </div>    
</div>
    <div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php 
    ActiveForm::end();
    Pjax::end();
?>

</div>

