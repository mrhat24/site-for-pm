<?php

use Netcarver\Textile;
use yii\helpers\Html;
use common\models\User;
use yii\data\ActiveDataProvider;
use common\models\GivenTask;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
$parser = new \Netcarver\Textile\Parser();

$this->title = 'Преподавателю';
?>
<div class="site-index">
	<?php
	echo Html::tag('h1',$this->title);                    
        ?>
        <div class="row">
        <div class="col-md-3"><?php            

        $menuItems = [
            ['label' => 'Распределение заданий '.Html::tag('span',Yii::$app->user->identity->teacher->newTasksCheckCount,['class' => 'badge'])
                , 'url' => Url::to(['given-task/control'])],
            ['label' => 'Задания', 'url' => Url::to(['task/control'])],
            ['label' => 'Упражнения', 'url' => Url::to(['exercise/control'])],
            ['label' => 'Расписание', 'url' => Url::to(['lesson/index','teacher' => Yii::$app->user->identity->teacher->id])],
        ];
        
        echo Nav::widget(['items' => $menuItems,
            'options' => ['class' => 'nav'],    
            'encodeLabels' => false,
            ]);
        ?></div>
            <div class="col-md-9">
                <?php
                $groups = Yii::$app->user->identity->teacher->groups;
                foreach($groups as $group) {
                    $groupTabs[] = ['label' => $group->name,
                        'content' => $this->render('teacher/groups',['group' => $group])];
                };
                $groupT = Tabs::widget([
                            'options' => ['class' => 'nav nav-pills nav-justified'],
                            'items' => 
                                $groupTabs, 
                        ]);
                    echo Tabs::widget([
                            'options' => ['class' => 'nav nav-pills nav-justified'],
                            'items' => [
                                [
                                    'label' => 'Группы',
                                    'content' => $groupT,
                                ],    
                                [
                                    'label' => 'Дипломники',
                                    'content' => 'Информация',                                    
                                ], 
                                [
                                    'label' => 'Курсовые',
                                    'content' => 'Информация',                                    
                                ], 
                                
                            ],
                        ]);
                ?>
            </div>

        
        </div>
	
</div>
<?php
Modal::begin([
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
?>