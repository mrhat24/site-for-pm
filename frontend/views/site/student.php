<?php
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\GivenTask;
$this->title = 'Студенту';
$this->params['breadcrumbs'][] = $this->title;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="site-student">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       <?php
     
       ?> 
    </p>   
    <div class="row">
    <?php            
    $menuItems = array();
    $menuItems[] = ['label' => 'Группа ('.Yii::$app->user->identity->student->group->name.")",'url' => Url::to(['group/my'])];  
      
    $menuItems[] = ['label' => 'Задания '.Html::tag('span',Yii::$app->user->identity->student->newTasksCount,['class' => 'badge']),'url' => Url::to(['task/taken'])];  
        
    echo Nav::widget(['items' => $menuItems,
            'options' => ['class' => 'nav'], 
            'encodeLabels' => false,
            ]);
    ?>
    </div>

</div>