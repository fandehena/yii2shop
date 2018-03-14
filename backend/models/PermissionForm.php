<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/7 0007
 * Time: 15:37
 */

namespace backend\models;


use Codeception\Module\Yii1;
use yii\base\Model;

class PermissionForm extends Model
{
    const SCENARIO_ADD='add';
    const SCENARIO_EDIT='edit';
    public $name;
    public $description;
public function attributeLabels()
{
    return [
        'name'=>'权限名',
        'description'=>'描述',
    ];
}
public function rules()
{
   return [
       [['name','description'],'required'],
       [['name'],'validateName','on'=>self::SCENARIO_ADD],
       [['name'],'ChangeName','on'=>self::SCENARIO_EDIT],
   ];
}
public function validateName(){
    $authManager = \Yii::$app->authManager;
   if($authManager->getPermission($this->name)){
       return $this->addError('name','权限已存在');
   };
}
public function ChangeName(){
    if(\Yii::$app->request->get('name') !=$this->name){
        $this->validateName();
    }
}
}