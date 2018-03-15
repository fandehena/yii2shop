<?php

namespace backend\models;

use backend\models\Admin;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\base\Model;

class LoginForm extends Model
{
    public $code;
    public $username;
    public $password;
    public $member;
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
//            'code'=>'验证码',
        ];
    }
    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['member'],'safe'],
            ['code','captcha','captchaAction'=>'admin/captcha',],
        ];
    }
    public function Login(){
        $login = Admin::findOne(['username'=>$this->username]);
        if ($login){
            if(\Yii::$app->security->validatePassword($this->password,$login->password_hash)){
                    $remember=$this->member?24*3600:0;
                return \Yii::$app->user->login($login,$remember);
               // var_dump($_SESSION);exit;
            }else{
                return   $this->addError('password','用户名或密码错误');
            }
        }else{
            return $this->addError('username','用户名或密码错误');
        }
    }
}