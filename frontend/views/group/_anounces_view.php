<?php
use yii\helpers\Html;

echo Html::beginTag('div',['class' => 'panel panel-info']);
echo Html::beginTag('div',['class' => 'panel-heading']);        
echo Html::tag('span',Html::tag('span','',['class' => 'glyphicon glyphicon-time']).' '.$model->dateTime,['class' => 'label label-info']);
echo Html::tag('h5',$model->user->fullname);
echo Html::endTag('div');
echo Html::tag('div',$model->text,['class' => 'panel-body']);
echo Html::endTag('div');