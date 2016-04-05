<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dialogs".
 *
 * @property integer $id
 * @property string $name
 * @property string $theme
 */
class Dialogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dialogs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'theme'], 'required'],
            [['theme'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'theme' => 'Theme',
        ];
    }
}
