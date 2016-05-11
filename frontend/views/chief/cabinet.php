<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Nav;
use yii\helpers\Url;

$this->title = 'Кабинет заведующего кафедры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="chief-cabinet">
<h2><?=$this->title?></h2>
    <div class="row">
        <div class="col-md-3">
            <?php
            echo Nav::widget([
                'items' => [
                    [
                        'label' => 'Главная',
                        'url' => Url::to(['site/index']),                        
                    ],
                ],                
            ]);
            ?>
        </div>
        <div class="col-md-9">
        <?php
            echo Tabs::widget([
                'options' => ['class' => 'nav nav-pills nav-justified'],
                'items' => [
                    [
                        'label' => 'Информация',                        
                        'content' => $this->render('_cabinet_information'),
                    ],
                    [
                        'label' => 'Дипломы',
                        'content' => $this->render('_cabinet_graduate'),
                    ],
                    [
                        'label' => 'Управление',
                        'content' => $this->render('_cabinet_graduate'),
                    ],
                ],
            ]);
        ?>
        </div>
    </div>
</div>
