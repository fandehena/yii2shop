<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\data\Pagination;
use yii\web\UploadedFile;
class GoodsController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        // $query=Goods::find();
        $request = \Yii::$app->request;
        // var_dump($_GET);exit;
        $get = $request->get();

        if ($get == null) {
            $pager = new Pagination();
            $query = Goods::find()->where(['status' => 0]);
            $pager->totalCount = $query->count();
            $pager->defaultPageSize = 10;
            $goods = $query->limit($pager->limit)->offset($pager->offset)->all();
            return $this->render('index', ['goods' => $goods, 'pager' => $pager]);
        }
        elseif ($get !== null) {
            {
                $name = $get['GoodsSearchForm']['name'];
                $sn = $get['GoodsSearchForm']['sn'];
                //var_dump($sn);exit;
                $minPrice = $get['GoodsSearchForm']['minPrice'];
                $maxPrice = $get['GoodsSearchForm']['maxPrice'];
                //var_dump($name);exit;
                $sql ='';
                if ($name !== null) {
                    $sql = ['like', 'name', $name];
                } elseif ($sn !== null) {
                    $sql = ['like', 'sn', $sn];
                } elseif ($minPrice !== null) {
                    $sql = ['>', 'market_price', $minPrice];
                } elseif ($maxPrice !== null) {
                    $sql = ['<', 'market_price', $maxPrice];
                }
                //var_dump($sql);exit;
                $query = Goods::find()->where(['status' => 0])->andWhere($sql);
                $pager = new Pagination();
                $pager->totalCount = $query->count();
                $pager->defaultPageSize = 20;
                $goods = $query->limit($pager->limit)->offset($pager->offset)->all();
                return $this->render('index', ['goods' => $goods, 'pager' => $pager]);
            }
        }
    }
    public function actionAdd()
    {
        $parent = new GoodsCategory();
        $nodes = GoodsCategory::find()->select(['id', 'name', 'parent_id'])->asArray()->all();
        $nodes[] = ['id' => 0, 'name' => '顶级分类', 'parent_id' => 0];
        $model = new Goods();
        $models = new GoodsIntro();
        $gdc = new GoodsDayCount();
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $model->load($request->post());
            $models->load($request->post());
            $gdc->load($request->post());
            $parent->load($request->post());
            // var_dump($parent);exit;
                $date = date('Ymd');
                $goodsCount = GoodsDayCount::findOne(['day' => $date]);
                //var_dump($goodsCount);exit;
                if ($goodsCount ==null) {
                    $gdc->day = $date;
                    $gdc->count = 0;
                }
                $count=$gdc->count+1;
               // var_dump($count);exit;
                $model->sn=$date.str_pad($count,5,"0",STR_PAD_LEFT);
                $gdc->count=$count;
                $gdc->save();
                $model->create_time = time();
                $model->goods_category_id = $parent->parent_id;
                $model->save();
                $models->goods_id = $model->id;
                $models->save();
                if ($parent->parent_id) {
                    $parents = GoodsCategory::findOne(['id' => $parent->parent_id]);
                    $parent->prependTo($parents);
                } else {
                    $parent->makeRoot();
                }
                $parent->name = $model->name;
                $parent->intro = $models->content;
                $parent->save();
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['goods/index']);
        }
        return $this->render('add', ['model' => $model, 'models' => $models, 'nodes' => json_encode($nodes), 'parent' => $parent]);
    }
    public function actionEdit(){
        $request= \Yii::$app->request;
        $id=$request->get('id');
        $model = Goods::findOne(['id'=>$id]);
        $models =GoodsIntro::findOne(['goods_id'=>$id]);
        $parent = new GoodsCategory();
        $nodes=GoodsCategory::find()->select(['id','name','parent_id'])->asArray()->all();
        $nodes[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        if($request->isPost){
            $model->load($request->post());
            $models->load($request->post());
            $parent->load($request->post());
            if($model->validate() && $models->validate()){
                $model->goods_category_id=$parent->parent_id;
                $model->save();
                $models->goods_id=$model->id;
                $models->save();
                if($parent->parent_id){
                    $parents=GoodsCategory::findOne(['id'=>$parent->parent_id]);
                    $parent->prependTo($parents);
                }else{
                    if($parent->getOldAttribute('parent_id')==0){
                        $parent->save();
                    }else {
                        $parent->makeRoot();
                    }
                }
                $parent->name=$model->name;
                $parent->intro=$models->content;
                $parent->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['goods/index']);
            }
        }
        return $this->render('add',['model'=>$model,'models'=>$models,'nodes'=>json_encode($nodes),'parent'=>$parent]);
    }
    public function actionDelete($id){

            $model=Goods::findOne(['id'=>$id]);
            if($model){
                if(!$model->delete()){
                    return 'fail';
                };
                return 'success';

            }
            $model->status=1;
            $model->save();
             return $this->redirect('index');
    }
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
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
    public function actionPhoto(){
        $model=new GoodsGallery();
        $request= \Yii::$app->request;
        $id=$request->get('id');
        $photos=  GoodsGallery::findAll(['goods_id'=>$id]);
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile =UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    //保存上传文件
                    $file = '/upload/'.uniqid().'.'.$model->imgFile->extension;
                    if($model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0)){
                        $model->path = $file;
                    }
                }
                $model->goods_id=$id;
                $model->save(0);
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['goods/photo'.'?id='.$model->goods_id]);
            }
        }
        return $this->render('photo',['model'=>$model,'photos'=>$photos]);
}
    public function actionDel($id){
    $model=GoodsGallery::findOne($id);
        if($model){
            if(!$model->delete()){
                return 'fail';
            };
            return 'success';
        }
    //var_dump($model->goods_id);exit;
    $model->delete();
    return $this->redirect(['goods/photo'.'?id='.$model->goods_id]);
}
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::class, //默认情况对所有操作生效
                'except'=>['upload','logo-upload']
            ]
        ];
    }
}
