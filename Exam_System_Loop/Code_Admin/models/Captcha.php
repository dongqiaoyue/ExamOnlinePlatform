<?php
namespace app\models;
use Yii;
use yii\base\Model;
class Captcha extends Model
{
    public $verifyCode;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // verifyCode needs to be entered correctly
            ['verifyCode', 'required'],
            ['verifyCode', 'captcha'],
        ];
    }
    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => '验证码',
        ];
    }
}