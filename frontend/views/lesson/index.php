<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Lesson;
use common\models\GroupHasDiscipline;
use common\models\Group;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\Tabs;
use yii\jui\Accordion;
use yii\i18n\Formatter;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJs(" 
        $('.list-group-item').children('.list-group').hide();
        $('.list-group-item span').on('click',function(e) { if (e.target != this) { return true; } if (e.target == this) { 
            $(this).children('.glyphicon').toggleClass('glyphicon-chevron-right').toggleClass('glyphicon-chevron-down');
            $(this).toggleClass('list-group-item-info');
            $(this).next('div.list-group').toggle(100); }              
        });         
");

$this->title = 'Расписание';
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['site/information'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lesson-index">
    
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::encode("Общее расписание");?>
    </p>
    
<?php
    
//Студенты    
$this->beginBlock('students');  
    Pjax::begin(['id' => 'group-block']);     
    $form = \yii\widgets\ActiveForm::begin(['id' => 'group-search-form','options' => ['data-pjax' => true , 'class' => 'form-inline']]);
    ?>
    <div class="form-group">
        <div class="input-group">
        <?php
        echo Html::tag('div','Группа ',['class' => 'input-group-addon']);
        echo Html::textInput('group_name',$groupRequest,['class' => 'form-control']);    
        ?>
        </div>
    <?php 
    echo Html::submitButton('Искать',['class' => 'btn btn-primary']);
    ?>
    </div>
    <?php
    echo Html::tag('hr');
    \yii\widgets\ActiveForm::end();   
    
    $menuItems = [];        
    foreach($groups as $g){       
            $menuItems[] = ['label' => $g->name,'url' => Url::to(['lesson/index','group' => $g->id])];      
    }
    echo Html::beginTag('div',['class' => 'list-group']);
    foreach($menuItems as $item){
        echo Html::a($item['label'],$item['url'],['class' => 'list-group-item']);
    }
    echo Html::endTag('div');  
    Pjax::end();
    
$this->endBlock('students');


//Преподаватели
$this->beginBlock('teachers');

    Pjax::begin(['id' => 'teacher-block']); 
    $form = \yii\widgets\ActiveForm::begin(['options' => ['data-pjax' => true , 'class' => 'form-inline']]);
    ?>
    <div class="form-group">
        <div class="input-group">
        <?php
        echo Html::tag('div','Фамилия ',['class' => 'input-group-addon']);
        echo Html::textInput('teacher_fullname',$teacherRequest,['class' => 'form-control']);    
        ?>
        </div>
    <?php
    echo Html::submitButton('Искать',['class' => 'btn btn-primary']);
    ?>
    </div>
    <?php
    
    \yii\widgets\ActiveForm::end();    
    
    echo Html::tag('hr');
    
    
    $menuItems = [];
    //$thd = Lesson::find()->select('teacher_id')->distinct()->all();
    foreach($teachers as $t){
        /*if(($t->teacher_id == Yii::$app->user->identity->teacher->id)){
            array_unshift($menuItems, ['label' => $t->teacher->user->fullname,'url' => Url::to(['lesson/index','teacher' => Yii::$app->user->identity->teacher->id])]);
        }
        else{*/
            $menuItems[] = ['label' => $t->user->fullname,'url' => Url::to(['lesson/index','teacher' => $t->id])];
        //}
    }
    echo Html::beginTag('div',['class' => 'list-group']);
    foreach($menuItems as $item){
        echo Html::a($item['label'],$item['url'],['class' => 'list-group-item']);
    }
    echo Html::endTag('div');
    Pjax::end();
$this->endBlock('teachers');

//Архив
$this->beginBlock('archive');
    
    $menuItems = [];    
    $formatter = Yii::$app->formatter;
    $groups = Group::find()->all(); 
    echo Html::beginTag('div',['class' => 'list-group']);
    foreach($groups as $gr){
        $count = \common\models\GroupSemesters::find()->where(['group_id' => $gr->id])->andWhere(['<=','end_date',date('U')])->count();
        if(!$count) break;
        echo Html::beginTag('div',['class' => 'list-group-item']);
        echo "<span class='list-group-item'><i class='glyphicon glyphicon-chevron-right'></i>{$gr->name}</span>";
        echo "<div class='list-group'  style='display: none;'>";        
        foreach($gr->semesters as $semester) {
            if($semester->end_date > date('U'))
                break;
            $link =  Url::toRoute(['lesson/archive','group' => $gr->id,'semester' => $semester->semester_number]);
            echo "<a href='{$link}' class='list-group-item'>Семестр: {$semester->semester_number}  "
            . "<span class='badge'>{$formatter->asDate($semester->begin_date)} — {$formatter->asDate($semester->end_date)}</span></a>";        
        }
        echo "</div>";
        echo Html::endTag('div');
    }
    echo Html::endTag('div');
    
    
$this->endBlock('archive');

?>
    <div class="panel panel-default">
        <div class="panel-body">
            
    <?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Группы',
                'content' => '<br>'.$this->blocks['students'],
            ],
            [
                'label' => 'Преподаватели',
                'content' => '<br>'.$this->blocks['teachers'],
            ],
            
            [
                'label' => 'Архив',
                'content' => '<br>'.$this->blocks['archive'],
            ]
        ],
        'options' => ['tag' => 'div', 'class' => 'nav nav-tabs'],
        'itemOptions' => ['tag' => 'div'],
        'clientOptions' => ['collapsible' => true],
    ]);
    ?>
        </div>
    </div>
    

</div>
