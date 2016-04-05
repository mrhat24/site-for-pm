<?php
use yii\bootstrap\Alert;
if(!$result) {
    echo Alert::widget([
     'options' => [
         'class' => 'alert-success',
     ],   
        'body' => 'Отправлено',
    ]);
    
}
else{
    echo Alert::widget([
     'options' => [
         'class' => 'alert-danger',
     ],   
        'body' => 'Вы не выполнили все задания!',
    ]);
    
}