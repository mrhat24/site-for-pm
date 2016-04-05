<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Message;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\User;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$user = User::find()->where(['id' => $userto])->one();

$this->title = 'Переписка с '.$user->fullname.("#").$user->id;
//$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => Url::to(['site/cabinet'])];
$this->params['breadcrumbs'][] = ['label' => 'Диалоги', 'url' => Url::to(['message/'])];
$this->params['breadcrumbs'][] = $this->title;
  

$this->registerJs('
        $("#refresh").on("click",function(){
$.pjax.reload({container:"#messages"});
}); 
        ');
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
      ?>
    <p>
        <?= Html::tag('h3',"Диалог c {$user->fullname}")  ?>
        <?= Html::img('@web/images/reload.png',['id' => 'refresh']) ?>
    </p>

    <?php Pjax::begin(['id' => 'messages', 'enablePushState' => false, ]); ?>
    <?php         
   /* $models = $dataProvider->getModels();
    foreach($models as $model)
    {
        echo $model->text.'<br>';
    }*/    
    ?>
    <?php  echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_message',
        'layout' => '{summary}{items}{pager}',       
        'options' => ['class' => 'message-list'],
        //'pager' => ['class' => \kop\y2sp\ScrollPager::className()]
    ])  ?>
    <?php Pjax::end(); ?>
    <?= $this->render('_form', [
        'model' => $model,
    ])  ?>
    

</div>
