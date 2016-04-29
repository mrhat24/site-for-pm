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
            echo Html::tag('h4',Yii::$app->user->identity->fullname);
        ?>
        <div class="row">
        <div class="col-md-3"><?php

        $menuItems = [
            ['label' => 'Задания '.Html::tag('span',Yii::$app->user->identity->student->newTasksCount,['class' => 'badge'])
                , 'url' => Url::to(['//given-task/control'])],            
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
                
                $lessons = Lesson::getLessonsList(['teacher' => Yii::$app->user->identity->student->id]);
                $schedule = Tabs::widget([
                    'items' => [
                        [
                        'label' => 'Неделя - 1',
                        'content' => Schedule::widget([
                            'scenario' => 'group',
                            'lessons' => $lessons,
                            'week' => 1]),
                        ],
                        [
                        'label' => 'Неделя - 2',
                        'content' => Schedule::widget([
                            'scenario' => 'group',
                            'lessons' => $lessons,
                            'week' => 2]),            
                        ]
                    ]
                ]);
                echo Tabs::widget([
                        'options' => ['class' => 'nav nav-pills nav-justified'],
                       // 'itemOptions' => ['class' => 'well'],                            
                        'items' => [
                            [
                                'label' => 'Профиль',
                                'content' => 'Профиль',              
                            ],
                            [
                                'label' => 'Расписание',
                                'content' => $schedule,              
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