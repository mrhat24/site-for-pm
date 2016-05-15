<?php

use Netcarver\Textile;
use yii\helpers\Html;
use common\models\User;
use yii\data\ActiveDataProvider;
use common\models\GivenTask;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$parser = new \Netcarver\Textile\Parser();

$this->title = 'ПМ';
?>
<div class="site-index">
    <?php
        echo Html::tag('h3','Добро пожаловать33');                    
    ?>	
</div>
