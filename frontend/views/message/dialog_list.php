<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Message;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\User;
use common\components\DateHelper;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$message_list = Message::find()
        ->from(['new_table' => Message::find()->orderBy(['id' => SORT_DESC])])
        ->where(['sender_id' => Yii::$app->user->id])        
        ->orWhere(['recipient_id' => Yii::$app->user->id])                
        ->select(['sender_id', 'recipient_id'])
        ->distinct()        
        ->all();
$dialog_list = array();
foreach($message_list as $message)
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
foreach($dialog_list as $dialog)
{
    $user = User::find()->where(['id' => $dialog])->one();
    $message = Message::find()->where(['sender_id' => $dialog])        
        ->orWhere(['recipient_id' => $dialog])
        ->orderBy('id DESC')
        ->one();    
    
    echo Html::beginTag('div',['class' => 'panel panel-info']);
    echo Html::beginTag('div',['class' => 'panel-heading container-fluid']);         
    echo Html::beginTag('div',['class' => 'col-xs-1']); 
    echo Html::a(Html::img($user->image),Url::to(['user/view','id' => $user->id]));
    echo Html::endTag('div'); 
    echo Html::beginTag('div',['class' => 'col-xs-11']); 
    echo Html::tag('h5',"Диалог с: ".$user->fullname); 
    echo Html::endTag('div');        
    echo Html::endTag('div');  
    echo Html::beginTag('div',['class' => 'panel-body']);      
    
    if($message->active == true)
    {
        echo Html::beginTag('div',['class' => 'alert alert-info']);
    }
    else
    {
        echo Html::beginTag('div',['class' => 'alert alert-success']);
    }
    
    echo Html::tag('h5',$message->sender->fullname.":");
    echo Html::beginTag('a',['href' => Url::to(['message/','usr' => $user->id]),'class' => 'alert-link']);
    echo substr($message->text, 0, 100)."...";
    echo Html::tag('h6', DateHelper::getDateByUserTimezone($message->datetime),
        ['class' => '']);
    echo Html::endTag('a');
    echo Html::endTag('div');   
    echo Html::endTag('div');    
    echo Html::endTag('div');
};

