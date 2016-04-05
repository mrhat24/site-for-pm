<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['site/cabinet']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-view">
 
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        echo Html::beginTag('div',['class' => 'panel']);
        echo Html::tag('span','Специальность - '.$model->speciality->name);
        echo Html::endTag('div');
    ?>   
</div>
