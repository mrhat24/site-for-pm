<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Work;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\WorkListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



function getWorkType($type = null){
    if($type == 1)
        return 'Темы дипломов';
    elseif($type == 2)
        return 'Темы курсовых';
    else
        return '';
};
$this->title = getWorkType($type);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Создать новую тему',  ['value' => Url::to(['//work-list/create','type' => $type]),'class' => 'btn btn-success modalButton']) ?>
    </p>
<?php Pjax::begin(['id' => 'work-list-pjax', 'enablePushState' => false]); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'name',

            [
                'class' => 'common\components\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model)
                            {
                                return Html::button('<span class="glyphicon glyphicon-trash"></span>',['value' => $url,
                        'class' => 'btn btn-default modalButton', 'data-confirm' => 'Вы уверены что хотите это удалить?']);
                            },
                ]
                
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
