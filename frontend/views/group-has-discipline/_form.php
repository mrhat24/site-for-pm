<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Discipline;
use common\models\Group;
use yii\helpers\ArrayHelper;
use common\models\GroupSemesters;
use common\components\DateHelper;
/* @var $this yii\web\View */
/* @var $model common\models\GroupHasDiscipline */
/* @var $form yii\widgets\ActiveForm */

$semesterList = $model->group_id ? ArrayHelper::map(GroupSemesters::find()->where(['group_id' => $model->group_id])->all(),'id','semester_number') : [];
if($semesterList != []){
    foreach ($semesterList as $key => $ar){
                     $semesterList[$key] = $ar." - (".
                             DateHelper::getDateByUserTimezone(GroupSemesters::findOne($key)->begin_date).':'.
                             DateHelper::getDateByUserTimezone(GroupSemesters::findOne($key)->end_date).')';           
    }
}
?>

<div class="group-has-discipline-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'discipline_id')->dropDownList(ArrayHelper::map(Discipline::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::find()->all(),'id','name'),[
        'prompt'=>'-Группа-',
            'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('group-has-discipline/semlist?id=').'"+$(this).val(), function( data ) {
                  $( "select#grouphasdiscipline-semestr_id" ).html( data );
                });
            ','class' => 'form-control']) ?>

    <?= $form->field($model, 'semestr_number')->dropDownList( $semesterList) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
