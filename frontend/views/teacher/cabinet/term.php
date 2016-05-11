<?php

use yii\helpers\Html;
use yii\helpers\Url;


$models = Yii::$app->user->identity->teacher->terms;
?>
<div class="well well-sm">
<?php
    if(!$models) 
        echo "Ничего не найдено";
    else {
        echo Html::tag('h5','Список курсовых работ');
        echo Html::beginTag('div',['class' => 'list-group']);
        foreach ($models as $model){
            echo Html::tag('div',$model->id,['class' => 'list-group-item']);
        }
        echo Html::endTag('div');
    }
    ?>
</div>