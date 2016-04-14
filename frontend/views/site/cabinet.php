<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Url;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-cabinet">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       <?php
     
       ?> 
    </p>   
    <div class="row">
        
        <?php            

        $menuItems = [
            ['label' => 'Профиль','url' => Url::to(['user/view'])],            
            ['label' => 'Диалоги'.Html::tag('span',Yii::$app->user->identity->newMessagesCount,['class' => 'badge']),'url' => Url::to(['message/'])],            
        ];                
        ?>
        <div class="row">
            <div class="col-md-2">
                <?php
                echo Nav::widget(['items' => $menuItems,
                    'options' => ['class' => 'nav'], 
                    'encodeLabels' => false,
                    ]);
                ?>
            </div>
            <div class="col-md-10">
                <?php if(Yii::$app->user->can('student')) echo $this->render('_cabinet_student.php'); ?>
            </div>
        </div>
    </div>

</div>
