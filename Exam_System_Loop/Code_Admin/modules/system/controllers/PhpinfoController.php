<?php
namespace app\modules\system\controllers;

use app\controllers\BaseController;

class PhpinfoController extends BaseController
{
    public function actionIndex(){
        phpinfo();
    }
}