<?php

namespace app\modules\reservation\controllers;

class ExamReservationController extends \app\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
