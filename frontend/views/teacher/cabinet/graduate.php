<?php

use yii\helpers\Html;
use yii\helpers\Url;


$models = Yii::$app->user->identity->teacher->graduates;
?>
<div class="well well-sm">
<?php
if(!$models) echo "Ничего не найдено";
else {
    echo Html::tag('h5','Список дипломных работ');
    echo Html::beginTag('div',['class' => 'list-group']);
    foreach ($models as $model){
        echo Html::tag('div',$model->workTitle->name,['class' => 'list-group-item']);
    }
    echo Html::endTag('div');
}
?>
</div>