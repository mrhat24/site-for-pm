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

$this->title = 'Кабинет преподавателя';
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
            ['label' => 'Распределение заданий '.Html::tag('span',Yii::$app->user->identity->teacher->newTasksCheckCount,['class' => 'badge'])
                , 'url' => Url::to(['given-task/control'])],
            ['label' => 'Задания', 'url' => Url::to(['task/control'])],
            ['label' => 'Упражнения', 'url' => Url::to(['exercise/control'])]            
        ];
        
        echo Nav::widget(['items' => $menuItems,
            'options' => ['class' => 'nav nav-pills nav-stacked'],
            'encodeLabels' => false,            
            ]);
        ?></div>
            <div class="col-md-9">
                <?php
                $groups = Yii::$app->user->identity->teacher->groups;
                foreach($groups as $group) {
                    $groupTabs[] = ['label' => $group->name,
                        'content' => $this->render('//teacher/cabinet/groups',['group' => $group])];
                };
                $groupT = Tabs::widget([
                            'options' => ['class' => 'nav nav-pills nav-justified'],
                            'items' => 
                                $groupTabs,
                        ]);
                $lessons = Lesson::getLessonsList(['teacher' => Yii::$app->user->identity->teacher->id]);
                $schedule = Tabs::widget([
                    'options' => ['class' => 'nav nav-pills nav-justified'],
                    'items' => [
                        [
                        'label' => 'Неделя - 1',
                        'content' => Schedule::widget([
                            'scenario' => 'teacher',
                            'lessons' => $lessons,
                            'week' => 1]),
                        ],
                        [
                        'label' => 'Неделя - 2',
                        'content' => Schedule::widget([
                            'scenario' => 'teacher',
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
                                'label' => 'Группы',
                                'content' => $groupT,
                            ],
                            [
                                'label' => 'Дипломы',
                                'content' => $this->render('//teacher/cabinet/graduate'), 
                            ],
                            [
                                'label' => 'Курсовые',
                                'content' => $this->render('//teacher/cabinet/term'), 
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