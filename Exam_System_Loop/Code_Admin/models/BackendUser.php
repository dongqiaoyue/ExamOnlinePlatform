<?php
namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;


class BackendUser extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;

    private $_menus;

    private $rightUrls;


    /**
     * 加密转换
     */
    public static function validatePassword($user, $password)
    {
        
        return ($user != null && Yii::$app->getSecurity()->validatePassword($password, $user->CuitMoon_UserPassWord));
    }

    /**
     * Logs in a user using the provided username and password.
     *登陆存session
     * @return boolean whether the user is logged in successfully
     */
    public static function login($username, $password, $rememberMe)
    {
        $user = tbCuitMoonUser::findByUsername($username);
        if (self::validatePassword($user, $password) == true) {
            if (Yii::$app->user->login($user, $rememberMe ? 3600 * 24 * 30 : 0) == true) {
                //首页左边树
//                $user->initUserModuleList();
//                $user->initUserUrls();
                return true;
            }
        }
        return false;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return tbCuitMoonUser::findOne([
            'CuitMoon_UserName' => $username,
        ]);
    }

    public static function findIdentity($id)
    {
        return self::findOne([
            'CuitMoon_UserID' => $id,
        ]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * cookie
     *
     * @see \yii\web\IdentityInterface::getId()
     */
    public function getId()
    {
        return $this->CuitMoon_UserID;
    }

//    public function getUserName()
//    {
//        return $this->CuitMoon_UserName;
//    }
    /**
     * cookie登录需要实现
     *
     * @see \yii\web\IdentityInterface::getAuthKey()
     */
    public function getAuthKey()
    {
        return $this->CuitMoon_UserAuthKey;
    }

    /**
     * cookie登录需要实现
     *
     * @see \yii\web\IdentityInterface::getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    public function getSystemMenus(){
        if(isset(Yii::$app->session['system_menus_'.$this->id]) == false){
            $this->initUserModuleList();
        }
        return Yii::$app->session['system_menus_'.$this->id];
    }

    public function getSystemRights(){
        if(isset(Yii::$app->session['system_rights_'.$this->id]) == false){
            $this->initUserUrls();
        }
        return Yii::$app->session['system_rights_'.$this->id];
    }

    public function clearUserSession(){
        Yii::$app->session['system_menus_'.$this->id] = null;
        Yii::$app->session['system_rights_'.$this->id] = null;
    }
}

?>