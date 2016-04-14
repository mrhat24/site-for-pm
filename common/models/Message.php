<?php

namespace common\models;

use Yii;

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

            $this->sender_id = Yii::$app->user->id;
            $this->datetime = date('U');

            return true;
        }
        return false;
        
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
