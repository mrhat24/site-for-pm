<?php
use yii\helpers\Html;
use common\models\Message;
use yii\helpers\Url;
$active = "";
$isnew = 'alert-info';
if($model->active == 0){
        $isnew = '';      
    }
if($model->recipient_id == Yii::$app->user->id)  {
    $img_class = 'pull-left';
    $span_class = 'message fl_left';
    $p_class = 'message-string text-left';      
    if($model->active == 1){        
        $model->active = 0;
        $model->save();
    }
}
else  { 
    $img_class = 'pull-right';
    $span_class = 'message fl_right';
    $p_class = 'message-string text-right';   
    if($model->active == 1){
    $p_class .= " message-active";
    }     
};



/*$message = Html::tag('p',Html::a(Html::img($model->sender->image,['class' => "img-thumbnail ".$img_class]),Url::to(['user/view','id' => $model->sender_id])).
            Html::tag('div',$model->text.Html::tag('h6',Yii::$app->formatter->asDateTime($model->datetime),['class' => '']), ['class' => '']),
    ['class' => $p_class]);*/
$img = Html::img($model->sender->image,['class' => "media-object img-thumbnail center-block",'style' => 'max-width: 128px; max-height: 128px;']);
$img = Html::tag('div',$img,['class' => 'media-left','style' => 'min-width: 140px;']);
$info = Html::tag('h6',Yii::$app->formatter->asDateTime($model->datetime));
$message = Html::tag('div',$model->text.$info,['class' => "media-body alert {$isnew}"]);
echo Html::tag('div',$img.$message,['class' => 'media alert list-group-item']);
    
?>