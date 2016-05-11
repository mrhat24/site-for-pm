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
use common\models\Lesson;
use common\widgets\Schedule;
/* @var $this yii\web\View */
$parser = new \Netcarver\Textile\Parser();

$this->title = 'Кабинет студента';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-index">
    <?php
        echo Html::tag('h1',$this->title);
    ?>
    <div class="row">
    <div class="col-md-3"><?php
    $group = Yii::$app->user->identity->student->group->name;
    $menuItems = [
        ['label' => "Группа {$group}",['class' => 'badge'] , 'url' => Url::to(['//group/my'])],
        ['label' => 'Задания '.Html::tag('span',Yii::$app->user->identity->student->newTasksCount,['class' => 'badge'])
            , 'url' => Url::to(['//given-task/taken'])],
        ['label' => 'Диплом',['class' => 'badge'] , 'url' => Url::to(['//work/graduate'])],
        ['label' => 'Курсовые',['class' => 'badge'], 'url' => Url::to(['//work/term'])],
    ];

    echo Nav::widget(['items' => $menuItems,
        'options' => ['class' => 'nav nav-pills nav-stacked'],
        'encodeLabels' => false,
        ]);
    ?></div>
        <div class="col-md-9">
            <?php                
            
            echo Tabs::widget([
                    'options' => ['class' => 'nav nav-pills nav-justified'],
                    'itemOptions' => ['class' => 'well well-sm', 'tag' => 'div'],
                    'items' => [
                        [
                            'label' => 'Профиль студента',
                            'content' => $this->render('cabinet/_student_profile'),
                        ],
                        [
                            'label' => 'Информация',
                            'content' => $this->render('cabinet/_info'),
                        ],
                        [
                            'label' => 'Уведомления',
                            'content' => '',
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