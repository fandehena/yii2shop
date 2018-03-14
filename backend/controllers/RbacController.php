<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/7 0007
 * Time: 14:26
 */

namespace backend\controllers;


use backend\filters\RbacFilter;
use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\web\Controller;

class RbacController extends Controller
{
  public function actionIndex()
  {
     $authManager = \Yii::$app->authManager;
     //创建权限
    // $permission= $authManager->createPermission('brand/add');
//      $permission->description="添加品牌";
//      $authManager->add($permission);
//      $permission= $authManager->createPermission('brand/index');
//      $permission->description='品牌列表';
//            $authManager->add($permission);
//      echo '添加成功';
      //角色
      //创建角色
//     $role= $authManager->createRole("小可爱");
//     $authManager->add($role);
//     $role1=$authManager->createRole("普通用户");
//     $authManager->add($role1);
//给juese添加权限
//     $role= $authManager->getRole("小可爱");
//     $permission=$authManager->getPermission("brand/add");
//     $permission2=$authManager->getPermission("brand/index");
//     $authManager->addChild($role,$permission);
//     $authManager->addChild($role,$permission2);
//     echo '添加完成';
//          $role= $authManager->getRole("普通用户");
//    $permission2=$authManager->getPermission("brand/index");
//    $authManager->addChild($role,$permission2);
//    echo '添加完成';
//$role1=$authManager->getRole("小可爱");
//$authManager->assign($role1,'14');
  }
  public function actionTest(){
      $result=\Yii::$app->user->can("brand/index");
      var_dump($result);
  }
  public function actionAddPermission(){
        $model=new PermissionForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $authManager=\Yii::$app->authManager;
                $permission= $authManager->createPermission($model->name);
                 $permission->description=$model->description;
                $authManager->add($permission);
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect('permission-index');
            }
        }
        return $this->render('permission-add',['model'=>$model]);
  }
  public  function actionPermissionIndex(){
            $permissions=\Yii::$app->authManager->getPermissions();
            return $this->render('permission-index',['permissions'=>$permissions]);
  }
  public function actionPermissionEdit($name)
  {
      $request = \Yii::$app->request;
      $authManager = \Yii::$app->authManager;
      $model = new PermissionForm();
      $model->scenario=PermissionForm::SCENARIO_EDIT;
      $permission = $authManager->getPermission($name);
      $model->name = $permission->name;
      $model->description = $permission->description;
      if ($request->isPost) {
          $model->load($request->post());
          if ($model->validate()) {
              $permission->name = $model->name;
              $permission->description = $model->description;
              $authManager->update($name, $permission);
              \Yii::$app->session->setFlash('success', '修改成功');
              return $this->redirect('permission-index');
          }
      }
      return $this->render('permission-add',['model'=>$model]);
  }
  public function actionDeletePermission($name){
      $authManager = \Yii::$app->authManager;
      $permission = $authManager->getPermission($name);
      $authManager->remove($permission);
      return $this->redirect('permission-index');
  }
  public function actionAddRole(){
 $model=new RoleForm();
$manager=\Yii::$app->authManager;
$request=\Yii::$app->request;
 $permission=$manager->getPermissions();
 if($request->isPost){
     $model->load($request->post());
     if($model->validate()){
         if($manager->getRole($model->name)){
             $model->addError('name','角色名已存在');
         }else{
             $role=$manager->createRole($model->name);
             $role->description=$model->description;
             $manager->add($role);
             $arrays=$model->permission;
             foreach ($arrays as $array){
                 $permission =$manager->getPermission($array);
                // var_dump($permission);exit();
                 $manager->addChild($role,$permission);
             }
            // var_dump($permissions);exit;
             \Yii::$app->session->setFlash('success','添加成功');
             return $this->redirect('role-index');
         }
     }
 }
 return $this->render('role-add',['model'=>$model]);
  }
  public function actionRoleIndex(){
      $permissions=\Yii::$app->authManager->getRoles();
      return $this->render('role-index',['permissions'=>$permissions]);
  }
  public function actionRoleDelete($name){
      $authManager = \Yii::$app->authManager;
      $role=$authManager->getRole($name);
      $authManager->remove($role);
      return $this->redirect('role-index');
  }
  public function actionRoleEdit($name){
      $request = \Yii::$app->request;
      $authManager = \Yii::$app->authManager;
      $model = new RoleForm();
      $role = $authManager->getRole($name);
     $permissions= $authManager->getPermissionsByRole($name);
     $model->permission=[];
     foreach ($permissions as $permission){
        $model->permission[]=$permission->name;
     }
      $model->name = $role->name;
      $model->description = $role->description;
      if ($request->isPost) {
          $model->load($request->post());
          if ($model->validate()) {
              $role->name = $model->name;
              $role->description = $model->description;
              $authManager->update($name, $role);
              $authManager->removeChildren($role);
              if(is_array($model->permission)){
             foreach ($model->permission as $per){
             $pms=$authManager->getPermission($per);
             $authManager->addChild($role,$pms);
}
              }
              \Yii::$app->session->setFlash('success', '修改成功');
              return $this->redirect('role-index');
          }
      }
      return $this->render('role-add',['model'=>$model]);
  }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::class, //默认情况对所有操作生效
            ]
        ];
    }
}