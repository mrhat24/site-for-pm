<?php
use yii\helpers\Html;
use common\models\Message;
use yii\helpers\Url;
$active = "";
if($model->sender_id != Yii::$app->user->id)  {
    $img_class = 'message-image fl_left';
    $span_class = 'message fl_left';
    $p_class = 'message-string text-left';
    if($model->active == 1){
    $p_class .= " message-active";
    }
    $model->active = 0;
    $model->save();
}
else  { 
    $img_class = 'message-image fl_right';
    $span_class = 'message fl_right';
    $p_class = 'message-string text-right';   
    if($model->active == 1){
    $p_class .= " message-active";
    }     
};
$date = new DateTime();
$date->setTimezone(new DateTimeZone('Asia/Krasnoyarsk'));
$date->setTimestamp($model->datetime);
echo Html::tag('p',Html::a(Html::img($model->sender->image,['class' => $img_class]),Url::to(['user/view','id' => $model->sender_id])).
            Html::tag('span',$model->text.Html::tag('span',$date->format("d:m:Y H:i:s"),['class' => 'message-time']), ['class' => $span_class]),
    ['class' => $p_class]);
    echo Html::tag('br',['class' => 'clear']);
?>
