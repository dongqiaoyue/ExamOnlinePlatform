<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model{

    public $excel;
    public $file;

    public function rules()
    {
        return [
          [['excel'],'file','extensions' => 'xls'],
          ['file','file']
        ];
    }
}