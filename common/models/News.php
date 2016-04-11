<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $text
 * @property integer $date
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['user_id', 'date'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

             $this->user_id = Yii::$app->user->id;
            $this->date = date('U');

            return true;
        }
        return false;       
    }
    
    public function getUser(){
        return $this->hasOne(User::className(),['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Название',
            'text' => 'Текст',
            'date' => 'Дата',
            'user.fullname' => 'Автор'
        ];
    }
}
