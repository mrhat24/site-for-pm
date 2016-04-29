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
        foreach ($models as $model){
            echo $model->workTitle->name.'<br>';
        }
    }
    ?>
</div>