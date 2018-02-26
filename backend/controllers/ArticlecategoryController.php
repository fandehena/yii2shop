<?php
namespace backend\controllers;
use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\UploadedFile;

class ArticlecategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {   $query=ArticleCategory::find();
        $pager=new Pagination();
        $pager->totalCount=$query->count();
        $pager->defaultPageSize=4;
        $articles= $query->where(['is_deleted'=>0])->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('index',['articles'=>$articles,'pager'=>$pager]);
    }
    public function actionAdd(){
        $request=\YII::$app->request;
        $model = new ArticleCategory();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile =UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    //保存上传文件
                    $file = '/upload/'.uniqid().'.'.$model->imgFile->extension;
                    if($model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0)){
                        $model->logo = $file;
                    }
                }
                $model->is_deleted=0;
                $model->sort=0;
                $model->save(0);
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['articlecategory/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit($id){
        $request= \Yii::$app->request;
        $id=$request->get('id');
        $model =  ArticleCategory::findOne(['id'=>$id]);
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile =UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    //保存上传文件
                    $file = '/upload/'.uniqid().'.'.$model->imgFile->extension;
                    if($model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0)){
                        $model->logo = $file;
                    }
                }
                $model->save(0);
                \Yii::$app->session->setFlash('success', '修改成功');
                return $this->redirect(['articlecategory/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($id){
        $model=ArticleCategory::findOne($id);
        $model->is_deleted=1;
        $model->save();
        return $this->redirect('index');
    }
}
