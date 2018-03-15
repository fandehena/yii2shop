<?php

namespace backend;

class controllersUserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
