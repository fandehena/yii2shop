<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/5 0005
 * Time: 14:10
 */
namespace backend\models;
use yii\base\Model;

class UpdateForm extends Model
{
    public $old;
    public $new;
    public $confirm;
    public $username;
    public function rules(){
        return [
           [['old','new','confirm'],'required'],
            ['confirm', 'compare', 'compareAttribute' => 'new','message'=>'两次输入的密码不一致'],
            [['old'],'ComparePassword'],
        ];
    }
    public function ComparePassword(){
        //只处理不通过的情况
        $result=\Yii::$app->security->validatePassword($this->old,\Yii::$app->user->identity->password_hash);
        if($result==false){
          $this->addError('old','旧密码输入不正确');
        }
    }
    public function attributeLabels(){
        return [
            'old'=>'旧密码',
            'new'=>'新密码',
            'username'=>'用户名',
            'confirm'=>'确认密码',
        ];
    }
}