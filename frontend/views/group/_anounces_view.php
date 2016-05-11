<?php
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\Url;


$date = Html::tag('span',Html::tag('span','',['class' => 'glyphicon glyphicon-time']).' '.
        Yii::$app->formatter->asDateTime($model->date),['class' => 'label label-info']);
$author = Html::tag('span',Html::button($model->user->fullname,
        ['value' => Url::to(['//user/view','id'=>$model->user->id]),
            'class' => 'btn-link modalButton']));
$body = Html::tag('div',Markdown::process($model->text),['class' => 'panel-body']);
$ad = Html::tag('h5',$author.$date);
$panel_head = Html::tag('div',$ad,['class' => 'panel-heading']);
$panel_body = Html::tag('div',$body,['class' => 'panel-body']);
echo Html::tag('div',$panel_head.$panel_body,['class' => 'panel panel-info']);