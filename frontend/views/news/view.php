<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <p><?=Html::encode($model->text)?></p>
    <div class="well well-sm">
        <div class="row">
            <div class="col-md-9"><h6> Дата добавления: <?= Yii::$app->formatter->asDatetime($model->date)?> 
                    | Автор: <?=Html::a($model->user->fullname,  Url::to(['user/view','id' => $model->user->id]))?><h6></div>
            <div class="col-md-3"></div>                         
        </div>
    </div>
    <hr/>
</div>
