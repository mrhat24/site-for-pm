<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="panel panel-default">
  <div class="panel-heading"><?php
    echo Html::a(Html::encode($model->title), ['/news/view', 'id' => $model->id]);
?></div>
  <div class="panel-body">
    <?=  StringHelper::truncate($model->text,400,'...');?>
    <div class="row">
        <div class="col-md-11"><h6> Дата добавления: <?= Yii::$app->formatter->asDatetime($model->date)?> | 
                Автор: <?=Html::a($model->user->fullname,  Url::to(['user/view','id' => $model->user->id]))?><h6></div>
        <div class="col-md-1"><?= Html::a('Читать',Url::to(['news/view','id' => $model->id]),['class' => 'btn btn-primary']); ?></div>
    </div>
  </div>
</div>