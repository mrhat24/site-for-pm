<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use yii\bootstrap\Modal;

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
                   /* [
                        'label' => 'Информация',                        
                        'content' => $this->render('_cabinet_information'),
                    ],*/
                    [
                        'label' => 'Информация',
                        'content' => $this->render('_cabinet_control'),
                    ],
                    [
                        'label' => 'Дипломы на утверждение',
                        'content' => $this->render('_cabinet_graduate'),
                    ],
                    
                ],
            ]);            
        ?>
        </div>
    </div>
</div>
<?php
Modal::begin([
            //'header' => '<h2>Управление заданиями</h2>',
            //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
?>