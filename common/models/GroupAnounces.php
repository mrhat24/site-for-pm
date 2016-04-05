<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "group_anounces".
 *
 * @property integer $id
 * @property integer $group
 * @property integer $user_id
 * @property string $text
 */
class GroupAnounces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group_anounces';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'text'], 'required'],
            [['group_id', 'user_id','date'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'group_id' => 'Группа',
            'user_id' => 'Пользователь',
            'text' => 'Текст',
            'date' => 'Дата'
        ];
    }
    
    public function beforeSave($insert) {
        $this->date = date('U');
        $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);        
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getDateTime()
    {
        return \common\components\DateHelper::getDateByUserTimezone($this->date);
    }
}
