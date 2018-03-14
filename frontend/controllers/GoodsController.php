<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/11 0011
 * Time: 15:48
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use Codeception\Module\Yii1;
use frontend\models\Cart;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Cookie;

class GoodsController extends Controller
{
    public function actionIndex()
    {
        $models = GoodsCategory::find()->where(['parent_id' => 0])->all();
        //var_dump($goods);exit;
        return $this->render('index', ['models' => $models]);
    }

    /**
     *
     */
    public function actionList()
    {
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $pager = new Pagination();
        $child = GoodsCategory::findOne(['id' => $id]);


        switch ($child->depth) {
            case 0:
            case 1:
                $ids = $child->children()->select(['id'])->andWhere(['depth' => 2])->asArray()->column();
                //var_dump($ids);exit;
                $models = Goods::find()->where(['in', 'goods_category_id', $ids])//->limit($pager->limit)->offset($pager->offset)
                ->all();
                //$query = $models;
//        $pager->totalCount = $query->count();
//        $pager->defaultPageSize = 8;
                break;
            case 2:
                $ids = [$id];
                $models = Goods::find()->where(['in', 'goods_category_id', $ids])//->limit($pager->limit)->offset($pager->offset)
                ->all();
                //$query = $models;
                //$pager->totalCount = $query->count();
                $pager->defaultPageSize = 10;
        }
        return $this->render('list', ['models' => $models]);
    }

    public function actionGoods()
    {
        $request = \Yii::$app->request;
        $id = $request->get('id');
        $model = Goods::findOne(['id' => $id]);
        $intro = GoodsIntro::findOne(['goods_id' => $id]);
        $pic = GoodsGallery::find()->where(['goods_id' => $id])->all();
        // var_dump($pic);exit;
        //var_dump($model);exit;
        return $this->render('goods', ['model' => $model, 'intro' => $intro, 'pic' => $pic]);
    }

    public function actionAddCart($goods_id, $count)
    {
        if (\Yii::$app->user->isGuest) {//未登录
            $cookies = \Yii::$app->request->cookies;
            $value = $cookies->getValue('carts');
            if ($value) {
                $carts = unserialize($value);
            } else {
                $carts = [];
            }
            if (array_key_exists($goods_id, $carts)) {
                $carts[$goods_id] += $count;
            } else {
                $carts[$goods_id] = $count;
            }
            //  $carts = unserialize($value);
            //将购物车数据保存到cookie
            $cookie = new Cookie();
            $cookie->name = 'carts';
            $cookie->value = serialize($carts);
            $cookie->expire = 10 * 3600 * 24 + time();
            $cookies = \Yii::$app->response->cookies;
            $cookies->add($cookie);

        } else {
            $request = \Yii::$app->request;
            $model = new Cart();
            $carts = Cart::findOne(['goods_id' => $goods_id]);
            if ($carts) {
                $carts->count = $carts->count + $count;
                $carts->save();
            } else {
                $model->load($request->get(), '');
                if ($model->validate()) {
                    $model->user_id = \Yii::$app->user->id;
                    $model->save();
                }
            }
        }
        return $this->render('success');
    }

    public function actionCart()
    {
        if (\Yii::$app->user->isGuest) {
            $cookie = \Yii::$app->request->cookies;
            $cart = $cookie->get('carts');
            if ($cart->value) {
                $carts = unserialize($cart->value);
            } else {
                $carts = [];
            }
        } else{
            $cts = Cart::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
//            var_dump($carts);exit;
            $carts = [];
            foreach ($cts as $cart){
                $carts[$cart['goods_id']]=$cart['count'];
            }

        }
        return $this->render('cart', ['carts' => $carts]);
    }
    public function actionDelete($goods_id,$amount){

        if (\Yii::$app->user->isGuest){
            $cookies = \Yii::$app->request->cookies;
            $value = $cookies->getValue('carts');
            //判断cookie里是否存在此商品
            if($value){
                $carts = unserialize($value);
            }else{
                $carts = [];
            }
            //如果购物车存在该商品,则改变改商品
            if($amount){
                $carts[$goods_id] = $amount;
            }else{
                //如果没有该商品则删除该商品
                unset($carts[$goods_id]);
                $cookie = new Cookie();
                $cookie->name = 'carts';
                $cookie->value = serialize($carts);
                $cookie->expire = 10*24*3600+time();
                $cookies = \Yii::$app->response->cookies;
                $cookies->add($cookie);
                return 'success';
            }
            //将购物车数据保存到cookie
            $cookie = new Cookie();
            $cookie->name = 'carts';
            $cookie->value = serialize($carts);
            $cookie->expire = 10*24*3600+time();
            $cookies = \Yii::$app->response->cookies;
            $cookies->add($cookie);
        }else{
            //实例化request组件
            $request = \Yii::$app->request;
            //实例化数据表
//            $model = new Cart();
            $carts = Cart::findOne(['goods_id'=>$goods_id]);
            if ($amount){
                $carts->amount = $amount;
                $carts->save(0);

            }else{
                $carts->delete();
                return 'success';
            }

        }
    }
}

