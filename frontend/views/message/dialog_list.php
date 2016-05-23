<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Message;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\User;
use common\components\DateHelper;
use yii\data\ActiveDataProvider;

$message_list = new ActiveDataProvider([
    'query' => Message::find()->where(['sender_id' => Yii::$app->user->id])
        ->orWhere(['recipient_id' => Yii::$app->user->id])
        ->select(['sender_id', 'recipient_id'])
]);        
        $message_list->query->orderBy(['datetime' =>  SORT_DESC, 'id' => SORT_DESC]);
       $messages = $message_list->getModels(); 
        /*Message::find()
        ->from(['new_table' => Message::find()->orderBy(['active' => SORT_ASC])])
        ->where(['sender_id' => Yii::$app->user->id])
        ->orWhere(['recipient_id' => Yii::$app->user->id])
        ->select(['sender_id', 'recipient_id'])
        ->distinct()
        ->all(); */

$dialog_list = array();

foreach($messages as $message)
{
    //echo $message->sender_id;
    if($message->sender_id == Yii::$app->user->id){
        $dialog_list[] = $message->recipient_id;
    }
    elseif($message->recipient_id == Yii::$app->user->id){
        $dialog_list[] = $message->sender_id;
    }
}
$dialog_list = array_unique($dialog_list);
echo '<div class="list-group">';
foreach($dialog_list as $dialog)
{
    $user = User::find()->where(['id' => $dialog])->one();
    $message = Message::find()->where(['sender_id' => $dialog])        
        ->orWhere(['recipient_id' => $dialog])
        ->orderBy('id DESC')
        ->one();            
    $messagetext = substr($message->text, 0, 40);
    $ss = (strlen($message->text) > strlen($messagetext));
    $messagetext = ($ss) ? ($messagetext."...") : $messagetext;
    echo Html::a("Диалог с ".$user->fullname."<br> ".$message->sender->fullname." пишет: ".$messagetext.
            Html::tag('span',Yii::$app->formatter->asDatetime($message->datetime),['class' => 'badge']),Url::to(['message/','usr' => $user->id]),
            ['class' => $message->active ? 'list-group-item active' : 'list-group-item']);
    
}

echo '</div>';