<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27 0027
 * Time: 15:32
 */

namespace backend\controllers;


use backend\models\Article;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Controller;

class ArticleController extends Controller
{
public function actionIndex(){
    $query=Article::find()->where(['is_deleted'=>0]);
    $pager=new Pagination();
    $pager->totalCount=$query->count();
    $pager->defaultPageSize=8;
   $articles = $query->offset($pager->offset)->limit($pager->limit)->all();
    return $this->render('index',['articles'=>$articles,'pager'=>$pager]);
}
public function actionAdd(){
        $request=\Yii::$app->request;
        $model=new Article();
        $models=new ArticleDetail();
        if($request->isPost){
            $models->load($request->post());
            $model->load($request->post());
        }
        if($model->validate() || $models->validate()){
          //var_dump($model->id);exit;
            $models->save();
            //var_dump($models);exit;
            $model->is_deleted=0;
            $model->create_time=time();
            $model->save();
            //var_dump($model);exit;
            $models->article_id=$model->id;
            $models->save();
            \Yii::$app->session->setFlash('success', '添加成功');
            return $this->redirect(['article/index']);
        };
        return $this->render('add',['model'=>$model,'models'=>$models]);
}
public function actionEdit($id){
    $request= \Yii::$app->request;
    $id=$request->get('id');
    $model = Article::findOne(['id'=>$id]);
    $models = ArticleDetail::findOne(['article_id'=>$id]);
    if($request->isPost){
        $models->load($request->post());
        $model->load($request->post());
        if($model->validate() || $models->validate()){
            $model->save();
            $models->save();
            \Yii::$app->session->setFlash('success', '修改成功');
            return $this->redirect(['article/index']);
        }
    }
    return $this->render('add',['model'=>$model,'models'=>$models]);
}
public function actionDelete($id){
    $model=Article::findOne($id);
    $model->is_deleted=1;
    $model->save();
    return $this->redirect('index');
}
public function actionShow($id){
    $request= \Yii::$app->request;
    $id=$request->get('id');
    //var_dump($id);exit;
    $contents=ArticleDetail::findOne([$id]);
  // var_dump($contents);exit;
   return $this->render('show',['contents'=>$contents]);
}
}