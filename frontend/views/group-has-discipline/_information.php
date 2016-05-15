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

$editBtn = Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
            ['value' => Url::to(['//group-has-discipline/update-info','id' => $model->id]),
                'class' => 'btn btn-sm btn-primary modalButton']);
$mdText = Markdown::process($model->information);
$info = Html::tag('span','Информация');
$data = Html::tag('div',$editBtn,['class' => 'panel-heading']);
$li = Html::tag('li',$editBtn,['class' => 'list-group-item']);
$ulHead = Html::tag('ul',$li,['class' => 'list-group']);
$data = Html::tag('div',$mdText,['class' => 'panel-body']);
echo Html::tag('div',$ulHead.$data,['class' => 'panel panel-primary']);

Pjax::end();