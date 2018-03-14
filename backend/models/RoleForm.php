<?php
namespace backend\models;
use Codeception\Lib\Generator\Helper;
use function PHPSTORM_META\map;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model{
    const SCENARIO_ADD='add';
    const SCENARIO_EDIT='edit';
    public $name;
    public $description;
    public $permission;
    public function rules(){
        return [
            [['name','description'],'required'],
            ['name','validateName','on'=>self::SCENARIO_ADD],
            ['name','changeName','on'=>self::SCENARIO_EDIT],
            ['permission','safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'用户名',
            'description'=>'简介',
            'permission'=>'权限',
        ];
    }
    public static function getPermissions(){
        $authManager=\Yii::$app->authManager;
        return ArrayHelper::map($authManager->getPermissions(),'name','description');
    }
    public function validateName(){
        $authManager = \Yii::$app->authManager;
        if($authManager->getRole($this->name)){
            return $this->addError('name','角色已存在');
        };
    }
    public function ChangeName(){
        if(\Yii::$app->request->get('name') !=$this->name){
            $this->validateName();
        }
    }
}