<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Message;
use yii\helpers\ArrayHelper;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = ['label' => 'Информация', 'url' => Url::to(['site/information'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,        
        'options' => ['class' => 'table table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            
            'fullname',
            'email:email',
            //'roleDescription',
            
            //'first_name',
            // 'middle_name',
            // 'last_name',            
            //'id',
            //'username',
            //'password_hash',
            //'password_reset_token',            
            // 'auth_key',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'password',\

            ['class' => 'yii\grid\ActionColumn',
            'header'=>'Действия', 
            //'headerOptions' => ['width' => '200'],
            'template' => '{view} {message}',
            'buttons' => [  
                            'message' => function ($url,$model,$key) {                    
                                return Html::a('Сообщение <span class="glyphicon glyphicon-envelope"></span>',
                                    Url::to(['/message','usr' => $model->id]),
                                        ['class' => 'btn btn-primary']);                                 
                            },
                            'view' => function($url,$model,$key){
                                return Html::a('Профиль <span class="glyphicon glyphicon-user"></span>',
                                        Url::to(['user/view','id' => $model->id]),
                                            ['class' => 'btn btn-primary']);
                            },
                        ]                    
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
