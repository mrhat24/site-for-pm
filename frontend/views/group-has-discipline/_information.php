<?php
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Pjax::begin(['enablePushState' => false, 'id' => 'ghd-info']);

if(isset(Yii::$app->user->identity->teacher)&&$model->checkTeacher(Yii::$app->user->identity->teacher->id))
$editBtn = Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
            ['value' => Url::to(['//group-has-discipline/update-info','id' => $model->id]),
                'class' => 'btn btn-sm btn-primary modalButton']);
else
    $editBtn = "";

$mdText = Markdown::process($model->information);
$info = Html::tag('span','Информация');
$data = Html::tag('div',$editBtn,['class' => 'panel-heading']);
$li = Html::tag('li',$editBtn,['class' => 'list-group-item']);
$ulHead = Html::tag('ul',$li,['class' => 'list-group']);
$data = Html::tag('div',$mdText,['class' => 'panel-body']);
echo Html::tag('div',$ulHead.$data,['class' => 'panel panel-primary']);

Pjax::end();