<?php
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use common\components\DateHelper;
use common\models\WorkHistory;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */?>
<div class="container-fluid">
<?php
$workListArr = ArrayHelper::map($workList, 'id', 'name', 'teacher.user.fullname');
$teachersArr = ArrayHelper::map($teachers, 'id', 'user.fullname');
$oldList = ArrayHelper::map(WorkHistory::find()->where(['work_id' => $workModel->id])->all(), 'id', 'name');
$disabledWorks = array();
foreach($workList as $work)
{
    if($work->isReserved){
        $disabledWorks[$work->id] = ['disabled' => true];
    }
}
foreach ($oldList as $key => $olde)
{
    $workH = WorkHistory::findOne($key);
    $oldList[$key] = $oldList[$key]." : ".  DateHelper::getDateByUserTimezone($workH->creation_date);
}

echo Html::tag('h2','Изменить тему');

Pjax::begin(['enablePushState' => false, 'id' => 'begin-graduate']);

$form = ActiveForm::begin([
    'id' => 'begin-graduate-form',
    'options' => ['class' => 'form-horizontal', 'data-pjax' => true],
]) ?>

<div class="form-group">
    <?=Html::label('Изменить текущий вариант'); ?>
    <div class="input-group ">
        <span class="input-group-addon">
            <?=Html::radio('source',true,['value' => 'edit'])?>
        </span>
        <?=Html::textInput('work_name',$workModel->workTitle->name,['class' => 'form-control', 'options' => $disabledWorks ]);    ?>
    </div>

</div>
<div class="form-group">
    <?=Html::label('История'); ?>
    <div class="input-group ">
        <span class="input-group-addon">
            <?=Html::radio('source',false,['value' => 'history'])?>
        </span>
        <?=Html::dropDownList('oldWorkList', null, $oldList,['class' => 'form-control', 'options' => $disabledWorks ]);?>
    </div>

</div>

<div class="form-group"> 
    <?=Html::label('Выбрать из списка преподавателя'); ?>
    <div class="input-group ">
        <span class="input-group-addon">
            <?=Html::radio('source',false,['value' => 'list'])?>
        </span>
        <?=Html::dropDownList('workList', null, $workListArr,['class' => 'form-control', 'options' => $disabledWorks ]);?>
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
