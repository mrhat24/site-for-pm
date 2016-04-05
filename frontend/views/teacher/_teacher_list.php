<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
?>


<div class="panel panel-default">
    <div class="panel panel-heading">
        <?= $model->user->fullname; ?>
    </div>
    <div class="panel panel-body">
        <div class="media">
            <div class="media-left media-middle">
              <a href="#">
                  <?= Html::img($model->user->image)?>
              </a>
            </div>
            <div class="media-body">
                
                Информация
                  
            </div>
        </div>
    </div>
</div>
