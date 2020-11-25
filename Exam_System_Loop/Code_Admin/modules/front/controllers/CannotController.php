<?php
namespace app\modules\front\controllers;

class CannotController extends BaseController
{
	public function actionIndex()
    {
        return $this->render('index');
    }
    // public function actionAddic()
    // {
    // 	return $this->render("addic");
    // }
    // 
    public function actionClose()
    {
    	return $this->render('close');
    }
}