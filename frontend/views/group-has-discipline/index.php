<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Nav;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\widgets\Schedule;
use common\models\Lesson;
use common\widgets\CommentsWidget;
use yii\helpers\Markdown;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->discipline->name.":".$model->group->name;
$this->params['breadcrumbs'][] = ['label' => $model->group->name, 'url' => Url::to(['//group/view','id' => $model->group->id])];
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('schedule');

$lessons = Lesson::find()->where(['ghd_id' => $model->id])->all();

echo Tabs::widget([
            'options' => ['class' => 'nav nav-pills nav-justified'],
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

$this->endBlock('schedule');

$this->beginBlock('desk');

echo CommentsWidget::widget(['class_name' => $model::className(),'item_id' => $model->id]);

$this->endBlock('desk');



?>
<div class="group-has-discipline-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <div class='row'>
        <div class="col-md-3">
            <?php
                
                $buttons = '';
                $buttons = $buttons.Html::a('Страница группы <span class="glyphicon glyphicon-briefcase"></span>',
                        Url::to(['//group/view','id' => $model->group->id]),['class' => 'btn btn-primary']);
                if(Yii::$app->user->can('teacher')){
                    $buttons = $buttons.Html::button('Назначить курсовые <span class="glyphicon glyphicon glyphicon-file"></span>',
                        ['value' => Url::to(['//work/term-create-group','group' => $model->group->id,'discipline' => $model->id]),'class' => 'btn btn-primary modalButton']);
                }
                $btngr = Html::tag('div',$buttons,['class' => 'btn-group']);
                
            echo Html::beginTag('ul',['class' => 'list-group']);
            echo Html::tag('li','Список преподавателей',['class' => 'list-group-item active']); 
            foreach($model->teacherHasDiscipline as $thd){
                $label = Html::button($thd->teacher->user->fullname,['value' => Url::to(['//teacher/view',
                    'id' => $thd->teacher->id]),
                    'class' => 'btn btn-sm btn-link modalButton']);
                echo Html::tag('li',$label,['class' => 'list-group-item']);
            }
            
            echo Html::endTag('ul');            
            echo Html::beginTag('ul',['class' => 'list-group']);
            echo Html::tag('li','Список студентов',['class' => 'list-group-item active']);
            foreach($model->group->students as $s){
                $label = Html::button($s->user->fullname,['value' => Url::to(['//student/view','id' => $s->id]),
                    'class' => 'btn btn-sm btn-link modalButton']);
                echo Html::tag('li',$label,['class' => 'list-group-item']);
                
            }
            echo Html::endTag('ul');
                       
            
        ?></div>
        <div class="col-md-9">
                <?php echo Html::tag('div', $btngr ,['class' => '']);?>
            </div>
        <div class="col-md-9">
            
                    <?php
                        echo Tabs::widget([
                            'items' => [
                                [
                                    'label' => 'Информация',
                                    'content' => $this->render('_information',['model' => $model]),
                                ],
                                [
                                    'label' => 'Расписание занятий',
                                    'content' => $this->blocks['schedule'],
                                ],
                                [
                                    'label' => 'Стена',
                                    'content' => $this->blocks['desk'],
                                ],
                            ],
                            'itemOptions' => ['tag' => 'div', 'class' => 'well well-sm'],
                            'options' => ['class' => 'nav nav-pills nav-justified']
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