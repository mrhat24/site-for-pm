<?php
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\Url;
echo Html::beginTag('div',['class' => 'panel panel-info']);
echo Html::beginTag('div',['class' => 'panel-heading']);        
echo Html::tag('span',Html::tag('span','',['class' => 'glyphicon glyphicon-time']).' '.Yii::$app->formatter->asDateTime($model->date),['class' => 'label label-info']);
echo Html::tag('h5',Html::a($model->user->fullname,Url::to(['//user/view','id'=>$model->user->id])));
echo Html::endTag('div');
echo Html::tag('div',Markdown::process($model->text),['class' => 'panel-body']);
echo Html::endTag('div');