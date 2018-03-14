<?php
namespace backend\filters;

use yii\web\HttpException;

class RbacFilter extends \yii\base\ActionFilter{
    public function beforeAction($action)
    {
        if(!\Yii::$app->user->can($action->uniqueId)){

            if(\Yii::$app->user->isGuest){
                return $action->controller->redirect(\Yii::$app->user->loginUrl)->send();
            }
            throw new HttpException(403,'对不起,你没有该权限');
        }
        return true;
    }
}
