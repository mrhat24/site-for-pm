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
    echo Html::tag('h4',Html::encode($model->title));
?></div>
    <div class="panel-body">
      <?=  StringHelper::truncate($model->text,400,'...');?>
    </div>    
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row">
                <div class="col-md-11"><h6> Дата добавления: <?= Yii::$app->formatter->asDatetime($model->date)?> | 
                        Автор: <?=Html::button($model->user->fullname,  ['value' => Url::to(['user/view','id' => $model->user->id]), 'class' => 'btn-link modalButton'])?><h6></div>
                <div class="col-md-1"><?= Html::a('Читать',Url::to(['news/view','id' => $model->id]),['class' => 'btn btn-primary']); ?></div>
            </div>
        </li>
    </ul>
</div>