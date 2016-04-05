<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\GroupSemesters;
use common\models\GroupHasDiscipline;
use yii\jui\Accordion;
use yii\bootstrap\Tabs;
/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-preview">
 
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        $this->beginBlock('students');
        echo Html::beginTag('ul',['class' => 'list-group']);
        foreach($model->studentsOrderedByLastName as $student)
        {
            echo Html::tag('li',$student->user->fullname,['class' => 'list-group-item']);
        }
        echo Html::endTag('ul');
        $this->endBlock('students');        
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            [                
                'value' => $model->speciality->name,
                'label' => 'Специальность',                        
            ],
            [   
                'label' => 'Список студентов',
                'value' => $this->blocks['students'], 
                'format' => 'html'
            ],            
        ],
    ]) ?>

</div>
