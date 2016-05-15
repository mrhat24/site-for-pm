<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->registerJs("$('body').delegate('.deleteCommentButton','click',function(){
        if(confirm('Удалить?')){
        $.post( $(this).attr('value'), function( data ) {
             $.pjax.reload({container:'#comments-pjax'}); 
         });   
        }
    });");


Pjax::begin(['enablePushState' => false, 'id' => 'comments-pjax']);

echo Html::tag('h3','Коментарии');
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{summary} {items} {pager}',
    'itemView' => '_item',
]);

Pjax::end();
