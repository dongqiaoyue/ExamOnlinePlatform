<?php
namespace app\models\phone;
use Yii;
use yii\base\Model;

class UploadFile extends Model{
    public $file;
    public function rules(){
        return [
            [['file'], 'file', 'skipOnEmpty' => true,'extensions' => 'ppt, pptx'],
        ];
    }
    public function attributeLabels(){
        return [
            'file'=>'文件上传'
        ];
    }
}
