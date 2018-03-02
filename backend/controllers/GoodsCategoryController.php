<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\data\Pagination;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query=GoodsCategory::find();
        $pager=new Pagination();
        $pager->totalCount=$query->count();
        $pager->defaultPageSize=20;
        $goods= $query->offset($pager->offset)->orderBy('tree ASC,depth ASC')->limit($pager->limit)->all();
        return $this->render('index',['goods'=>$goods,'pager'=>$pager]);
    }
    public function actionAdd(){
        $model =new GoodsCategory();
        $nodes=GoodsCategory::find()->select(['id','name','parent_id'])->asArray()->all();
        $nodes[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id){
                    $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);
                }else{
                    $model->makeRoot();
                }
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods-category/index']);
            }
        }
        return $this->render('add',['model'=>$model,'nodes'=>json_encode($nodes)]);
    }
public function actionTest(){
     //   $parent=GoodsCategory::findOne(['id'=>1]);
//    $countries = new GoodsCategory(['name' => '家用电器']);
//    $countries->parent_id=0;
//    $countries->makeRoot();
//    echo '添加成功';
//    $russia = new GoodsCategory(['name' => '手机']);
//    $russia->parent_id=1;
//    $russia->prependTo($parent);
//    echo '添加成功';
}
public function actionEdit(){
    $request= \Yii::$app->request;
    $id=$request->get('id');
    $model =  GoodsCategory::findOne(['id'=>$id]);
    $nodes=GoodsCategory::find()->select(['id','name','parent_id'])->asArray()->all();
    $nodes[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
    if($request->isPost){
        $model->load($request->post());
        if($model->validate()){
            if($model->parent_id){
                $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                $model->prependTo($parent);
            }else{
                $model->makeRoot();
            }
            $model->save();

            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['goods-category/index']);
        }
    }
    return $this->render('add',['model'=>$model,'nodes'=>json_encode($nodes)]);
}

    public function actionDelete($id){
        $model=GoodsCategory::findOne($id);
        $model->delete();
        return $this->redirect('index');
    }
//    public function actionTree(){
//        $model=GoodsCategory::find()->select(['id','name','parent_id'])->all();
//            var_dump($model);exit;
//    }

}
