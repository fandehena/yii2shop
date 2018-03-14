<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/10 0010
 * Time: 9:34
 */

namespace frontend\controllers;


use app\models\Address;
use yii\web\Controller;

class AddressController extends Controller
{
    public function actionIndex()
    {
        $Members= Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        return $this->render('index',['Members'=>$Members]);
    }

    public function actionAdd(){
        $model= new Address();
        $request = \Yii::$app->request;
        if ($request->isPost){
//            var_dump($request->post());exit;
            $model->load($request->post(),'');
                $model->user_id=\Yii::$app->user->id;
                $model->provence =$model->cmbProvince;
                $model->city=$model-> cmbCity;
                $model->area=$model->cmbArea;
                $model->save();
                return $this->redirect(['address/index']);
        }
        return $this->render('index');
    }
    public function actionEdit(){

        $request = \Yii::$app->request;
        $id = $request->get('id');

        $edit_address = Address::findOne(['id'=>$id])->toArray();
       return json_encode($edit_address);
    }
    //修改保存
    public function actionEditSave(){
        $request = \Yii::$app->request;
        //实例化表单模型
        $address = Address::findOne(['id'=>$request->post('id')]);
        if ($request->isPost){
            $address->load($request->post(),'');
            if ($address->validate()){
                $address->provence =$address->cmbProvince;
                $address->city=$address-> cmbCity;
                $address->area=$address->cmbArea;
                //var_dump($address);exit;
                $address->save();
                return $this->redirect(['address/index']);
            }
        }
    }
public function actionDelete($id){
    $model=Address::findOne(['id'=>$id]);
//    if($model){
//        if(!$model->delete()){
//            return 'fail';
//        };
//        return 'success';
//    }
    $model->delete();
 return $this->redirect('index.html');
}
}