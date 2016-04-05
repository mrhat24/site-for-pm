<?php
use yii\bootstrap\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\models\WorkList;
use yii\helpers\ArrayHelper;
use common\models\WorkHistory;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Редактирование названия курсовой работы';

$workList = ArrayHelper::map(WorkList::find()
        ->where(['teacher_id' => $model->teacher_id
                ,'work_type_id' => $model::TYPE_TERM])
        ->all(),'id','name','teacher.user.fullname');
$oldList = ArrayHelper::map($model->workHistory,'id','name');
?>
<p>
    <h2><?=$this->title?></h2>
</p>
<div class="container-fluid">
<?php
    Pjax::begin(['enablePushState' => false, 'id' => 'begin-term']);
    $form = ActiveForm::begin([
        'id' => 'begin-graduate-form',
        'options' => ['class' => 'form-horizontal', 'data-pjax' => true],
    ]) 
?>
    <div class="form-group">
        <?=Html::label('Изменить название'); ?>
        <div class="input-group ">
            <span class="input-group-addon">
                <?=Html::radio('source',true,['value' => 'edit'])?>
            </span>            
            <?=Html::textInput('editName',$model->workTitle ? $model->workTitle->name : null,['class' => 'form-control']);    ?>
        </div>
    </div>
    
    <?php if($model->reserved_id != null) { ?>
    <div class="form-group">
        <?=Html::label('Создать новую тему'); ?>
        <div class="input-group ">
            <span class="input-group-addon">
                <?=Html::radio('source',false,['value' => 'new'])?>
            </span>            
            <?=Html::textInput('newName',null,['class' => 'form-control']);    ?>
        </div>
    </div>
     <?php
            }
    ?>

    <div class="form-group">
    <?=Html::label('Старые варианты'); ?>
    <div class="input-group ">
        <span class="input-group-addon">
            <?=Html::radio('source',false,['value' => 'history'])?>
        </span>
        <?=Html::dropDownList('oldWorkName', null, $oldList,['class' => 'form-control']);?>
    </div>
    </div>
    <div class="form-group">
        <?=Html::label('Выбрать из списка преподавателя'); ?>
        <div class="input-group ">
            <span class="input-group-addon">
                <?=Html::radio('source',false,['value' => 'list'])?>
            </span>
            <?=Html::dropDownList('listWorkName',null,$workList,['class' => 'form-control'])   ?>
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