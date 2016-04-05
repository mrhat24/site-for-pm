<?php

use Netcarver\Textile;
use yii\helpers\Html;
use common\models\User;
use yii\data\ActiveDataProvider;
use common\models\GivenTask;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
$parser = new \Netcarver\Textile\Parser();

$this->title = 'Преподавателю';
?>
<div class="site-index">
	<?php
	echo Html::tag('h1',$this->title);                    
        ?>
        <div class="row">
        <div class="col-md-4"><?php            

        $menuItems = [            
            ['label' => 'Выдача заданий '.Html::tag('span',Yii::$app->user->identity->teacher->newTasksCheckCount,['class' => 'badge'])
                , 'url' => Url::to(['given-task/control'])],
            ['label' => 'Управление заданиями', 'url' => Url::to(['task/control'])],
            ['label' => 'Управление упражнениями', 'url' => Url::to(['exercise/control'])]
        ];
        
        echo Nav::widget(['items' => $menuItems,
            'options' => ['class' => 'nav'],    
            'encodeLabels' => false,
            ]);
        ?></div>
        <div class="col-md-8">.col-md-4</div>

        
        </div>
	
</div>
