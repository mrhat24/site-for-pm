<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SpecialitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Специальности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Добавить специальность',['value'=> Url::to(['create']),
        'class' => 'btn btn-success modalButton']);?> 
    </p>
<?php Pjax::begin(['enablePushState' => false]); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
    'options' => ['class' => 'table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'code',
            'start_date',
            //'standart.name',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<?php
    
        Modal::begin([                               
                'id' => 'modal',
                'size' => 'modal-lg',    
                'options' => [
                        'tabindex' => false
                    ]
            ]);        
        echo "<div id='modalContent'></div>";
        Modal::end();
        
    ?>