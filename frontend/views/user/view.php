<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->fullname;
//$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['site/cabinet']]; 
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
           // 'username',
           // 'password_hash',
           // 'password_reset_token',
            [
                'label' => 'Фото',
                'value' => $model->image,
                'format' => ['image',['max-width: 200px', 'max-heigth' => '200px','class' => 'img-thumbnail']],
            ],
            'email:email',
           // 'auth_key',
          //  'status',
          //  'created_at',
          //  'updated_at',
         //   'password',
            'first_name',
            'middle_name',
            'last_name',
            //'roleDescription',
        ],
    ]) ?>

</div>
