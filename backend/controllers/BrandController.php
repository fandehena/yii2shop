<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\UploadedFile;
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

class BrandController extends \yii\web\Controller
{
    public $enableCsrfValidation =false;
    public function actionIndex()
    {   $query=Brand::find()->where(['is_deleted'=>0]);
        $pager=new Pagination();
        $pager->totalCount=$query->count();
        $pager->defaultPageSize=4;
      $brands= $query->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render('index',['brands'=>$brands,'pager'=>$pager]);
    }
    public function actionAdd(){
        $request=\YII::$app->request;
        $model = new Brand();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->is_deleted=0;
                $model->sort=0;
                $model->save();
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['brand/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionEdit(){
    $request= \Yii::$app->request;
    $id=$request->get('id');
    $model =  Brand::findOne(['id'=>$id]);
    if($request->isPost){
        $model->load($request->post());
        if($model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success', '修改成功');
            return $this->redirect(['brand/index']);
        }
    }
    return $this->render('add',['model'=>$model]);
}
    public function actionDelete($id){
        $model=Brand::findOne(['id'=>$id]);
        if($model){
            if(!$model->delete()){
                return 'fail';
            };
            return 'success';

        }
        $model->is_deleted=1;
        $model->save();
    $model->is_deleted=1;
    $model->save();
}
public function actionLogoUpload()
{
    $uploadedFile = UploadedFile::getInstanceByName('file');
    $fileName = '/upload/'.uniqid() .'.'.$uploadedFile->extension;
    $result = $uploadedFile->saveAs(\Yii::getAlias('@webroot').$fileName);
    if($result){
        //文件保存成功
        //将图片上传到七牛云
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey ="p__Avo94pM47IW2XyaN677kVk9eGXp02XgmypDiP";
        $secretKey = "9fqtNmgcYYMgkhiACfDUNg8f-psvyBAKGDWI48kp";
        //存储空间的名称
        $bucket = "yiishop";
        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 生成上传 Token
        $token = $auth->uploadToken($bucket);
        // 要上传文件的本地路径
        $filePath = \Yii::getAlias('@webroot').$fileName;
        // 上传到七牛后保存的文件名
        $key = $fileName;
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if($err == null){
            //上传七牛云成功
            //访问七牛云图片的地址http://<domain>/<key>
            return json_encode([
                'url'=>"http://p4v47oexd.bkt.clouddn.com/{$key}"
            ]);
        }else{
            return json_encode([
                'url'=>$err
            ]);
        }
    }else{
        return json_encode([
            'url'=>"fail"
        ]);
    }
}
    //测试文件上传七牛云
//    public function actionTest(){
//        // 需要填写你的 Access Key 和 Secret Key
//        $accessKey ="p__Avo94pM47IW2XyaN677kVk9eGXp02XgmypDiP";
//        $secretKey = "9fqtNmgcYYMgkhiACfDUNg8f-psvyBAKGDWI48kp";
//        //存储空间的名称
//        $bucket = "yiishop";
//        // 构建鉴权对象
//        $auth = new Auth($accessKey, $secretKey);
//        // 生成上传 Token
//        $token = $auth->uploadToken($bucket);
//        // 要上传文件的本地路径
//        $filePath = \Yii::getAlias('@webroot').'/upload/1.jpg';
//        // 上传到七牛后保存的文件名
//        $key = '/upload/1.jpg';
//        // 初始化 UploadManager 对象并进行文件的上传。
//        $uploadMgr = new UploadManager();
//        // 调用 UploadManager 的 putFile 方法进行文件的上传。
//        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//        echo "\n====> putFile result: \n";
//        if ($err !== null) {
//            //上传有错误
//            var_dump($err);
//        } else {
//            //上传成功
//            echo '上传成功';
//            var_dump($ret);
//        }
//    }
}
