<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\models\GroupSemesters;
use common\components\DateHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Предметы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-has-discipline-index">
    
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Создать',['value'=> Url::to(['group-has-discipline/create']),
        'class' => 'btn btn-success modalButton']);?>     
    </p>
    
    <?php Pjax::begin(['enablePushState' => false]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'disciplineName',
            'groupName',
            'semester_number',
            [
                'label' => 'Преподаватели',
                'value' => function($model){
                    $teachers = $model->teacherHasDiscipline;
                    $result = "";
                    foreach($teachers as $teacher){
                        $result = $result."<br>".$teacher->teacher->user->fullname;
                    }
                    return $result;
                },
                'format' => 'html',
            ],
             
            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
<?php
Modal::begin([
            'header' => '<h2>Управление заданиями</h2>',
            //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
            'id' => 'modal',
            'size' => 'modal-lg', 
            'options' => [
                //'id' => 'kartik-modal',
                'tabindex' => false // important for Select2 to work properly
            ],
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
