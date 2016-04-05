<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Message;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\User;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Диалоги';
//$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => Url::to(['site/cabinet'])];
//$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => Url::to(['user/index'])];
$this->params['breadcrumbs'][] = $this->title;
  

$this->registerJs('
        $("#refresh").on("click",function(){
$.pjax.reload({container:"#messages"});
}); 
        ');
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('dialog_list'); ?>

</div>
