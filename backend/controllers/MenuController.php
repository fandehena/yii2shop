<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/8 0008
 * Time: 11:05
 */

namespace backend\controllers;


use backend\filters\RbacFilter;
use backend\models\Menu;
use yii\web\Controller;

class MenuController extends Controller
{
    public function actionIndex(){
    $menus=Menu::find()->all();
    return $this->render('index',['menus'=>$menus]);
}
public function actionAdd(){
        $model=new Menu();
    $parents=Menu::find()->where(['parent_id'=>0])->all();
    $res=[];
    $res[0]='顶级分类';
    foreach ($parents as $parent){
        $res[$parent->id]=$parent->name;
    }
    $request=\Yii::$app->request;

    if($request->isPost){
        $model->load($request->post());
        if($model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['menu/index']);
        }
    }
     return  $this->render('add',['model'=>$model,'res'=>$res]);
}
    public function actionEdit(){
        $request=\Yii::$app->request;
        $id=$request->get('id');
        $model=Menu::findOne(['id'=>$id]);
        $parents=Menu::find()->where(['parent_id'=>0])->all();
        $res=[];
        $res[0]='顶级分类';
        foreach ($parents as $parent){
            $res[$parent->id]=$parent->name;
        }
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['menu/index']);
            }
        }
        return  $this->render('add',['model'=>$model,'res'=>$res]);
}
    public function actionDelete($id){
    $model=Menu::findOne(['id'=>$id]);
        if($model){
            if(!$model->delete()){
                return 'fail';
            };
            return 'success';
        }
    $model->delete();
    return $this->redirect('index');
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