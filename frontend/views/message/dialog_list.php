<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Message;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\User;
use common\components\DateHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
$user = Yii::$app->user->id;
//$query = Message::find()        
//        ->where(['and',"sender_id={$user}","recipient_id!={$user}"])
//        ->orWhere(['and',"sender_id!={$user}","recipient_id={$user}"]);       
//$message_list = new ActiveDataProvider([
//        'query' => $query/*Message::find()->where(['sender_id' => Yii::$app->user->id])
//            ->orWhere(['recipient_id' => Yii::$app->user->id])
//            ->select(['sender_id', 'recipient_id'])*/
//    ]);                
//       $message_list->query->orderBy(['datetime' =>  SORT_DESC, 'id' => SORT_DESC]);       
//       $count = $message_list->count;
//       $messages = $message_list->getModels();
//       $dialog_list = array();
//echo json_encode(ArrayHelper::toArray($messages));
//foreach($messages as $message)
//{    
//    if($message->sender_id == Yii::$app->user->id){
//        $dialog_list[$message->recipient_id][] = $message;
//    }
//    elseif($message->recipient_id == Yii::$app->user->id){
//        $dialog_list[$message->sender_id][] = $message;
//    }
//}
//echo json_encode(ArrayHelper::toArray($dialog_list));
//foreach($dialog_list as $key => $dialog){
//    ArrayHelper::multisort($dialog_list, ['id'], SORT_DESC);
//}
//echo "///".json_encode(ArrayHelper::toArray($dialog_list));
////$dialog_list = array_unique($dialog_list);
//echo '///<div class="list-group">22';

$dialog_list = Message::DialogList($user);
foreach($dialog_list as $dialog){        
    if($dialog->sender_id != $user)
        $dialog_user = User::find()->where(['id' => $dialog->sender_id])->one();
    elseif($dialog->sender_id == $user)
        $dialog_user = User::find()->where(['id' => $dialog->recipient_id])->one();
    $messagetext = substr($dialog->text, 0, 40);
    $ss = (strlen($dialog->text) > strlen($messagetext));
    $messagetext = ($ss) ? ($messagetext."...") : $messagetext;
    echo Html::a("Диалог с ".$dialog_user->fullname."<br> ".$dialog->sender->fullname." пишет: ".$messagetext.
            Html::tag('span',Yii::$app->formatter->asDatetime($dialog->datetime),['class' => 'badge']),Url::to(['message/','usr' => $dialog_user->id]),
            ['class' => $dialog->active ? 'list-group-item active' : 'list-group-item']);
    
}

echo '</div>';