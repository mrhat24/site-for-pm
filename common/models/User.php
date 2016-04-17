<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    const ROLE_USER = 1;
    const ROLE_STUDENT = 5;
    const ROLE_TEACHER = 10;
    const ROLE_CHIEF = 15;
    const ROLE_ADMIN = 99;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name','middle_name','last_name','timezone'],'string', 'max' => 255],
            ['email' , 'email'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['timezone', 'default', 'value' => 'Asia/Krasnoyarsk'],
            //['role', 'default', 'value' => '1'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['image', 'default', 'value' => '@web/images/demo/avatar.png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }   

        /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * get fullname
     */
    public function getFullname()
    {
        return $this->last_name.' '.$this->first_name.' '.$this->middle_name.' ';
    }
    
    /**
     * 
     * @get 
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Электронная почта',
            'first_name' => 'Имя',
            'middle_name' => 'Отчетство',
            'last_name' => 'Фамилия',
            'fullname' => 'Ф.И.О.',
            'role' => 'Роль',
            'timezone' => 'Часовой пояс',
        ];
    }
    
    public function getRole()
    {
        if(!Yii::$app->user->isGuest){
            $roles = Yii::$app->authManager->getRolesByUser($this->id);
                foreach($roles as $role)
                return $role;
        }
        
    } 
    public function getIsTeacher()
    {
        if(Teacher::findOne(['user_id' => $this->id])) return true;
        else return false;
    }
    
    public function getIsStudent()
    {
        if(Student::findOne(['user_id' => $this->id])) return true;
        else return false;
    }
    
    public function getStudent(){
        return $this->hasOne(Student::className(),['user_id' => 'id']);
    }
    
    public function getTeacher(){
        return $this->hasOne(Teacher::className(),['user_id' => 'id']);
    }        
    
    public function getNewMessagesCount()
    {
        return Message::find()->where(['recipient_id' => $this->id])
                ->andWhere(['active' => 1])
                ->count();
    }
    
}
