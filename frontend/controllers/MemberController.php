<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/9 0009
 * Time: 11:08
 */

namespace frontend\controllers;






use Codeception\Module\Yii1;
use frontend\models\Cart;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\web\Controller;

class MemberController extends  Controller
{
    public function actionRegister()
    {
        {
            $request = \Yii::$app->request;
            $model = new Member();
            if ($request->isPost) {
                $model->load($request->post(), '');
                if ($model->validate()) {

                    $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
                    $time = time();
                    $model->status = 1;
                    $model->created_at = $time;
                    $model->save();
                    \Yii::$app->session->setFlash('success', '注册成功');
                    return $this->redirect(['member/login']);
                }
            }
            //展示注册表单
            return $this->render('register');
        }
    }
    public function actionLogin(){
        $request=\Yii::$app->request;
        $mode=new LoginForm();
        //var_dump($model);exit
        if ($request->isPost){;
            $mode->load($request->post(),'');
            if ($mode->validate()){
                if ($mode->login()) {
                    $cookie = \Yii::$app->request->cookies;
                    $cart = $cookie->getValue('carts');
                   // var_dump($cart);exit;
                    if ($cart) {
                        $carts = unserialize($cart);
                        foreach ($carts as $goods_id => $count) {
                            $model = new Cart();
                            $cart = Cart::findOne(['goods_id' => $goods_id, 'user_id' => \Yii::$app->user->id]);
                        }
                        if ($cart) {
                            $cart->count =$count;
                            $cart->save();
                            //var_dump($cart);exit;
                        }
                        else {
                            $model->goods_id = $goods_id;
                            $model->count = $count;
                            $model->user_id = \Yii::$app->user->id;
                            $model->save();
                        }

                    }
                    $models = Member::findOne(['username' => $mode->username]);
                    //var_dump($model);exit;
                    $time = time();
//var_dump($models);exit;
                    $models->last_login_time = $time;
                    $models->last_login_ip = ip2long($_SERVER['SERVER_ADDR']);
                    $models->save();
                    \Yii::$app->session->setFlash('info', '登陆成功');
                    return $this->redirect(['address/index']);
                }
            }
        }
        return $this->render('login');
    }
    public function actionLogout(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('info','退出登陆成功');
        return $this->redirect(['member/login']);
    }
//    public function actionTestSms()
//    {
//        $r = \Yii::$app->sms->setTel('15283231379')->setParams(['code' => rand(100000, 999999)])->send();
//        var_dump($r);
//    }
    public function actionCode($tel,$code){
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $c = $redis->get('code'.$tel);
        if($c == $code){
            return 'true';
        }
        return 'false';
    }
    public function actionSms($tel){
      //  var_dump($tel);
        $code = rand(1000,9999);
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $redis->set('code'.$tel,$code,10*60);
        $r=\Yii::$app->sms->setTel($tel)->setParams(['code'=>$code])->send();
        if($r){
            return 'success';
        }
        return 'fail';
    }
    public function actionTest(){
        var_dump(\Yii::$app->user->isGuest);
    }
}