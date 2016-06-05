<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->fullname;
//$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['site/cabinet']]; 
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="btn-group">
    <?php
        if($model->isStudent){
            echo Html::button('Профиль студента',['value' => Url::to(['//student/view','id' => $model->student->id]), 'class' => 'btn btn-sm btn-primary modalButton']);
        }
    ?>
    <?php
        if($model->isTeacher){
            echo Html::button('Профиль преподавателя',['value' => Url::to(['//teacher/view','id' => $model->teacher->id]), 'class' => 'btn btn-sm btn-primary modalButton']);
        }
    ?>
    
     <?php
        echo Html::button('<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Сообщение',
                        ['class' => 'btn btn-primary btn-sm modalButton','value'=> Url::to(['//message/create','id' => $model->id])] );
    ?>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [           
            [
                'label' => 'Фото',
                'value' => $model->image,
                'format' => ['image',['max-width: 200px', 'max-heigth' => '200px','class' => 'img-thumbnail']],
            ],
            'email:email',
            'first_name',
            'middle_name',
            'last_name',
            'role'
        ],
    ]) ?>
    

</div>
