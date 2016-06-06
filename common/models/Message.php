<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $from_id
 * @property integer $to_id
 * @property string $text
 * @property integer $active
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['sender_id','recipient_id', 'active','datetime'], 'integer'],
            [['sender_id'], 'compare', 'compareAttribute' => 'recipient_id','operator' => '!='],            
            [['text'], 'string'],
            ['active','default','value' => 1],
            ['datetime','default','value' => date('U')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Отправитель',
            'recipient_id' => 'Получатель',
            'text' => 'Текст',
            'active' => 'Не прочитано',
        ];
    }
    
    public function beforeSave($insert) {
       if (parent::beforeSave($insert)) {
            
            $this->datetime = date('U');

            return true;
        }
        return false;
        
    }
    
    public static function DialogList($user){
        
        $query = Message::find()        
        ->where(['and',"sender_id={$user}","recipient_id!={$user}"])
        ->orWhere(['and',"sender_id!={$user}","recipient_id={$user}"]);       
        $message_list = new ActiveDataProvider([
                'query' => $query                 
            ]);              
        $message_list->query->orderBy(['datetime' =>  SORT_DESC, 'id' => SORT_DESC]);       
        $count = $message_list->count;
        $messages = $message_list->getModels();
        $dialog_list = array();
                
        foreach($messages as $message)
        {    
            if($message->sender_id == Yii::$app->user->id){
                $dialog_list[$message->recipient_id][] = $message;
            }
            elseif($message->recipient_id == Yii::$app->user->id){
                $dialog_list[$message->sender_id][] = $message;
            }
        }        
        ArrayHelper::multisort($dialog_list, ['id'], SORT_DESC);
        $result = array();
        foreach($dialog_list as $dialog){
            $result[] = $dialog[0];
        }        
        return $result;
    }

    /**
     * @get user 
     */
    public function getSender()
    {
        return $this->hasOne(User::className(),['id' => 'sender_id']);
    }
    
    /**
     * @get user 
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(),['id' => 'recipient_id']);
    }

}
