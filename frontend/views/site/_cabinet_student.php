<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo Html::tag('h3','Студенту');
if(Yii::$app->user->identity->student->newTasksCount) {
    echo Html::beginTag('div',['class' => 'alert alert-warning alert-info']);
    echo Html::a("Новых заданий: ".Yii::$app->user->identity->student->newTasksCount, Url::toRoute('/task/taken'));
    echo Html::endTag('div');
}