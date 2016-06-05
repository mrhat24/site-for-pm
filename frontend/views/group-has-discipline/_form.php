<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Discipline;
use common\models\Group;
use yii\helpers\ArrayHelper;
use common\models\GroupSemesters;
use common\components\DateHelper;
use unclead\widgets\MultipleInput;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\GroupHasDiscipline */
/* @var $form yii\widgets\ActiveForm */

$semesterList = $model->group_id ? ArrayHelper::map(GroupSemesters::find()->where(['group_id' => $model->group_id])->all(),'id','semester_number') : [];
if($semesterList != []){
    foreach ($semesterList as $key => $ar){
                     $semesterList[$key] = $ar." - (".
                            Yii::$app->formatter->asDate(GroupSemesters::findOne($key)->begin_date).':'.
                             Yii::$app->formatter->asDate(GroupSemesters::findOne($key)->end_date).')';           
    }
}
?>

<div class="group-has-discipline-form">
    
    <?php $form = ActiveForm::begin([
        'id'=>'project-form',
        'enableAjaxValidation'      => true,
        /*'enableClientValidation'    => false,
        'validateOnChange'          => true,
        'validateOnSubmit'          => true,
        'validateOnBlur'            => false,*/
        ]); ?>
    
    <?= $form->field($model, 'teacherHasDiscipline')->widget(MultipleInput::className(),  ['min' => 1,'columns' => [
        [
            'name'  => 'teacher_id',
            'type'  => 'dropDownList',
            //'title' => 'Преподаватель',
            'defaultValue' => 1,            
            'items' => ArrayHelper::map(\common\models\Teacher::find()->all(),'id','user.fullname')
        ],
    ]])?>

    <?= $form->field($model, 'discipline_id')->dropDownList(ArrayHelper::map(Discipline::find()->all(),'id','name')) ?>

    <?= $model->isNewRecord ? $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(Group::find()->all(),'id','name'),[
        'prompt'=>'-Группа-',
            'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('group-has-discipline/semlist?id=').'"+$(this).val(), function( data ) {
                  $( "select#grouphasdiscipline-semester_id" ).html( data );
                });
            ','class' => 'form-control']) : "" ?>

    <?= $model->isNewRecord ? $form->field($model, 'semester_number')->widget(DepDrop::classname(), [
        'options'=>['id'=>'semester_number'],
        'pluginOptions'=>[
            'depends'=>['grouphasdiscipline-group_id'],
            'placeholder'=>'Выберите группу...',
            'url'=>Url::to(['/group-has-discipline/semesters'])
        ]
    ]) : $form->field($model, 'semester_number')->dropDownList($semesterList) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>    
</div>
