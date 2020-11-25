<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbcuitmoon_user".
 *
 * @property string $CuitMoon_UserID
 * @property string $CuitMoon_UserName
 * @property string $CuitMoon_UserPassWord
 * @property string $CuitMoon_UserRealName
 * @property string $CuitMoon_UserSex
 * @property string $CuitMoon_UserBirthday
 * @property string $CuitMoon_UserCellphone
 * @property string $CuitMoon_UserAddress
 * @property string $CuitMoon_UserZipCode
 * @property string $CuitMoon_UserEmail
 * @property string $CuitMoon_UserQQ
 * @property string $CuitMoon_UserMSN
 * @property string $CuitMoon_UserRegTime
 * @property integer $CuitMoon_UserLoginCount
 * @property string $CuitMoon_UserStatus
 * @property string $CuitMoon_AreaCode
 * @property string $CuitMoon_DepartmentID
 * @property string $CuitMoon_UserLoginStatus
 * @property string $CuitMoon_UserWorkingStatus
 * @property string $CuitMoon_UserLevel
 * @property string $CuitMoon_Discount
 * @property string $CuitMoon_UserRemarks
 * @property string $CuitMoon_UserAuthKey
 */
class TbcuitmoonUser extends \app\models\BackendUser
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbcuitmoon_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CuitMoon_UserID', 'CuitMoon_UserName', 'CuitMoon_UserPassWord'], 'required','message' => '必须填写'],
            [['CuitMoon_UserName'],'unique','message' => '不能重复'],
            [['CuitMoon_UserBirthday', 'CuitMoon_UserRegTime'], 'safe'],
            [['CuitMoon_UserLoginCount'], 'integer'],
            [['CuitMoon_Discount'], 'number'],
            [['CuitMoon_UserID', 'CuitMoon_DepartmentID'], 'string', 'max' => 32],
            [['CuitMoon_UserName', 'CuitMoon_UserRealName'], 'string', 'max' => 20],
            [['CuitMoon_UserPassWord', 'CuitMoon_UserAddress', 'CuitMoon_UserEmail', 'CuitMoon_UserMSN', 'CuitMoon_AreaCode', 'CuitMoon_UserAuthKey'], 'string', 'max' => 100],
            [['CuitMoon_UserSex', 'CuitMoon_UserLoginStatus', 'CuitMoon_UserWorkingStatus', 'CuitMoon_UserLevel'], 'string', 'max' => 50],
            [['CuitMoon_UserCellphone'], 'string', 'max' => 15],
            [['CuitMoon_UserZipCode'], 'string', 'max' => 10],
            [['CuitMoon_UserQQ'], 'string', 'max' => 12],
            [['CuitMoon_UserRemarks'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CuitMoon_UserID' => 'Cuit Moon  User ID',
            'CuitMoon_UserName' => 'Cuit Moon  User Name',
            'CuitMoon_UserPassWord' => 'Cuit Moon  User Pass Word',
            'CuitMoon_UserRealName' => 'Cuit Moon  User Real Name',
            'CuitMoon_UserSex' => 'Cuit Moon  User Sex',
            'CuitMoon_UserBirthday' => 'Cuit Moon  User Birthday',
            'CuitMoon_UserCellphone' => 'Cuit Moon  User Cellphone',
            'CuitMoon_UserAddress' => 'Cuit Moon  User Address',
            'CuitMoon_UserZipCode' => 'Cuit Moon  User Zip Code',
            'CuitMoon_UserEmail' => 'Cuit Moon  User Email',
            'CuitMoon_UserQQ' => 'Cuit Moon  User Qq',
            'CuitMoon_UserMSN' => 'Cuit Moon  User Msn',
            'CuitMoon_UserRegTime' => 'Cuit Moon  User Reg Time',
            'CuitMoon_UserLoginCount' => 'Cuit Moon  User Login Count',
            'CuitMoon_UserStatus' => 'Cuit Moon  User Status',
            'CuitMoon_AreaCode' => 'Cuit Moon  Area Code',
            'CuitMoon_DepartmentID' => 'Cuit Moon  Department ID',
            'CuitMoon_UserLoginStatus' => 'Cuit Moon  User Login Status',
            'CuitMoon_UserWorkingStatus' => 'Cuit Moon  User Working Status',
            'CuitMoon_UserLevel' => 'Cuit Moon  User Level',
            'CuitMoon_Discount' => 'Cuit Moon  Discount',
            'CuitMoon_UserRemarks' => 'Cuit Moon  User Remarks',
            'CuitMoon_UserAuthKey' => 'Cuit Moon  User Auth Key',
        ];
    }
}
