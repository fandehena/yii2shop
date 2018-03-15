<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Admin;
//use backend\models\EditPasswordForm;
//use backend\models\Update;
use backend\models\ResetForm;
use backend\models\UpdateForm;
use Codeception\Module\Yii1;
use yii\web\Controller;

class AdminController extends Controller
{
    public function actionIndex()
    {
         $admins=Admin::find()->all();
        return $this->render('index',['admins'=>$admins]);}
    public function actionAdd(){
        $model=new Admin();
        $request=\Yii::$app->request;
        $authManager=\Yii::$app->authManager;
        if($request->isPost){
            $model->load($request->post());
                if($model->validate()){
                    $time=date('Ymd',time());
                   $model->auth_key=\yii::$app->security->generateRandomKey();
                    $model->created_at=$time;
                   $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
                    //$role1=$authManager->getRole("小可爱");
                    //$authManager->assign($role1,'14');
                    $model->save();
                    $arrays=$model->roles;
                    foreach ($arrays as $array){
                        $role =$authManager->getRole($array);
                        // var_dump($permission);exit();
                        $authManager->assign($role,$model->id);
                    }
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['admin/index']);
                }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit(){
        $request=\Yii::$app->request;
        $authManager=\Yii::$app->authManager;
        $id=$request->get('id');
        $model=Admin::findOne(['id'=>$id]);
       // $role = $authManager->getRole($id);
        $roles= $authManager->getRolesByUser($id);
        $model->roles=[];
        foreach ($roles as $role){
            $model->roles[]=$role->name;
        }
    if($request->isPost){
        $model->load($request->post());
        if($model->validate()){
            $authManager->revokeAll($model->id);
            $time=time();
            $model->updated_at=date('Ymd',$time);
            $model->password_hash = \Yii::$app->security->generatePasswordHash($model->passwords);
            $model->save();
            $arrays=$model->roles;
            if(is_array($model->roles)) {
                foreach ($arrays as $array) {
                    $role = $authManager->getRole($array);
                    // var_dump($permission);exit();
                    $authManager->assign($role, $model->id);
                }
            }
        }
        \Yii::$app->session->setFlash('success','修改成功');
        return $this->redirect(['admin/index']);
    }
    return $this->render('add',['model'=>$model]);}
    public function actionDelete($id){
    $model=Admin::findOne(['id'=>$id]);
    if($model){
        if(!$model->delete()){
            return 'fail';
        };
        return 'success';
    }
    $model->delete();
    return $this->redirect('index');
}
    public function actionLogin(){
    $request=\Yii::$app->request;
       $model=new \backend\models\LoginForm();
       //var_dump($model);exit
        if ($request->isPost){;
            $model->load($request->post());
            if ($model->validate()){
                if ($model->login()){
                    $id=$_SESSION['__id'];
                    $models=Admin::findOne(['id'=>$id]);
                    $time=date('Y-m-d H:i:s',time());
                    $models->last_login_time=$time;
                    $models->last_login_ip=ip2long(\Yii::$app->request->userIP);
                    $models->save();
                    \Yii::$app->session->setFlash('info','登陆成功');
                    return $this->redirect(['admin/index']);
                }
            }
        }
        return $this->render('login',['model'=>$model]);}
    public function actionLogout(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('info','退出登陆成功');
        return $this->redirect(['admin/login']);
    }
    public function actionUpdate()
    {
        $user=\yii::$app->user->identity;
       // var_dump($user);exit;
        $model=new UpdateForm();
        //var_dump($user);exit;
        $request=\Yii::$app->request;
       // var_dump($user);exit;
        $model->username=$user->username;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
            $user->password_hash=\Yii::$app->security->generatePasswordHash($model->new);
                 $user->save();
                 //var_dump($user);exit;
                \Yii::$app->session->setFlash('success','修改成功');
                \Yii::$app->user->logout();
                return $this->redirect(['admin/login']);
            }
        }
            return $this->render('update', ['model'=>$model]);}
    public function actionReset()
    {   $request=\Yii::$app->request;
        $id=$request->get('id');
        $model=Admin::findOne(['id'=>$id]);
        $models=new ResetForm();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->password_hash = \Yii::$app->security->generatePasswordHash($models->passwords);
                $model->save();
            }
            \Yii::$app->session->setFlash('success','重置成功');
            return $this->redirect(['admin/index']);
        }
        return $this->render('reset',['model'=>$model,'models'=>$models]);
    }
    public function actions(){
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                //设置验证码参数
                'minLength'=>3,
                'maxLength'=>4,
            ],
        ];
    }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::class, //默认情况对所有操作生效
                'except'=>['login','logout','captcha'],
            ]
        ];
    }
}
