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
  

$this->registerJs("
    
    $('#refresh_button').on('click',function(){
            $.pjax.reload({container:'#messages'});
            rotate();
            $('#messages').on('pjax:end',   function() { clearTimeout(timer); });
    }); ");
$this->registerJs("
    var elie = $('#refresh'), degree = 0, timer;
    function rotate() {
        
        elie.css({ WebkitTransform: 'rotate(' + degree + 'deg)'});  
        elie.css({ '-moz-transform': 'rotate(' + degree + 'deg)'});                      
        timer = setTimeout(function() {
            ++degree; rotate();
        },5);
    }
");
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
      ?>
    <p>
        <?= Html::tag('h3',"Диалог c {$user->fullname}")  ?>
    <div class='row'>
        <div class='col-md-11'></div>
        <div class='col-md-1' style="text-align: right;">
            <button class='btn btn-primary' id='refresh_button'><span class="glyphicon glyphicon-refresh" id='refresh' aria-hidden="true"></span></button>
        </div>
    </div>
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
        'itemOptions' => ['class' => ''],
        'itemView' => '_message',
        'layout' => '{summary}{items}{pager}',       
        'options' => ['class' => 'panel panel-default'],
        //'pager' => ['class' => \kop\y2sp\ScrollPager::className()]
    ])  ?>
    <?php Pjax::end(); ?>
    <?= $this->render('_form', [
        'model' => $model,
    ])  ?>
    

</div>
